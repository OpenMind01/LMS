<?php
/**
 * Created by Justin McCombs.
 * Date: 10/15/15
 * Time: 11:02 AM
 */

namespace Pi\Importing\Word;
use Artack\DOMQuery\DOMQuery;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Autoloader as WordAutoloader;
use Pi\Clients\Client;
use Pi\Clients\Courses\Article;
use Pi\Clients\Courses\Module;
use Pi\Importing\Exceptions\FiletypeNotSupportedException;
use Pi\Utility\Assets\AssetStorageService;
use XMLReader;
use DOMDocument;
class WordImporter
{

    protected $filePath;

    protected $phpWord;

    protected $html;

    protected $images;
    /**
     * @var AssetStorageService
     */
    private $assetStorage;

    /**
     * WordImporter constructor.
     * @param AssetStorageService $assetStorage
     */
    public function __construct(AssetStorageService $assetStorage)
    {
        WordAutoloader::register();
        $this->phpWord = new PhpWord;
        $this->images = new Collection;
        $this->assetStorage = $assetStorage;
    }

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }



    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        if ( ! file_exists($this->filePath))
            throw new \Exception('File Does Not Exist.');

//        $this->phpWord = IOFactory::load($this->filePath);

        return $this;
    }

    public function readDocxContent($xmlFile)
    {
        $reader = new XMLReader;
        $reader->open($xmlFile);

        // set up variables for formatting
        $text = ''; $formatting['bold'] = 'closed'; $formatting['italic'] = 'closed'; $formatting['underline'] = 'closed'; $formatting['header'] = 0;

        // loop through docx xml dom
        while ($reader->read()){

            // look for new paragraphs
            if ($reader->nodeType == XMLREADER::ELEMENT && $reader->name === 'w:p'){

                // set up new instance of XMLReader for parsing paragraph independantly
                $paragraph = new XMLReader;
                $p = $reader->readOuterXML();

                $paragraph->xml($p);

                // search for heading
                preg_match('/<w:pStyle w:val="(Heading.*?[1-6])"/',$p,$matches);
                if (count($matches)){
                    switch($matches[1]){
                        case 'Heading1': $formatting['header'] = 1; break;
                        case 'Heading2': $formatting['header'] = 2; break;
                        case 'Heading3': $formatting['header'] = 3; break;
                        case 'Heading4': $formatting['header'] = 4; break;
                        case 'Heading5': $formatting['header'] = 5; break;
                        case 'Heading6': $formatting['header'] = 6; break;
                        default:  $formatting['header'] = 0; break;
                    }

                    // open h-tag or paragraph
                    $text .= ($formatting['header'] > 0) ? '<h'.$formatting['header'].'>' : '<p>';
                }else {
                    $text .= '<p>';
                };


                // loop through paragraph dom
                while ($paragraph->read()){
                    // look for elements
                    if ($paragraph->nodeType == XMLREADER::ELEMENT && $paragraph->name === 'w:r'){
                        $node = trim($paragraph->readInnerXML());

                        // add <br> tags
                        if (strstr($node,'<w:br ')) $text .= '<br>';

                        // look for formatting tags
                        $formatting['bold'] = (strstr($node,'<w:b/>')) ? (($formatting['bold'] == 'closed') ? 'open' : $formatting['bold']) : (($formatting['bold'] == 'opened') ? 'close' : $formatting['bold']);
                        $formatting['italic'] = (strstr($node,'<w:i/>')) ? (($formatting['italic'] == 'closed') ? 'open' : $formatting['italic']) : (($formatting['italic'] == 'opened') ? 'close' : $formatting['italic']);
                        $formatting['underline'] = (strstr($node,'<w:u ')) ? (($formatting['underline'] == 'closed') ? 'open' : $formatting['underline']) : (($formatting['underline'] == 'opened') ? 'close' : $formatting['underline']);

                        // build text string of doc
                        $text .=     (($formatting['bold'] == 'open') ? '<strong>' : '').
                            (($formatting['italic'] == 'open') ? '<em>' : '').
                            (($formatting['underline'] == 'open') ? '<u>' : '').
                            htmlentities(iconv('UTF-8', 'ASCII//TRANSLIT',$paragraph->expand()->textContent)).
                            (($formatting['underline'] == 'close') ? '</u>' : '').
                            (($formatting['italic'] == 'close') ? '</em>' : '').
                            (($formatting['bold'] == 'close') ? '</strong>' : '');

                        // reset formatting variables
                        foreach ($formatting as $key=>$format){
                            if ($format == 'open') $formatting[$key] = 'opened';
                            if ($format == 'close') $formatting[$key] = 'closed';
                        }
                    }
                }
                $text .= ($formatting['header'] > 0) ? '</h'.$formatting['header'].'>' : '</p>';
            }

        }
        $reader->close();

        // suppress warnings. loadHTML does not require valid HTML but still warns against it...
        // fix invalid html
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        @$doc->loadHTML($text);
        $goodHTML = simplexml_import_dom($doc)->asXML();
        $this->html = $goodHTML;

        return $goodHTML;
    }

    public function readDocxSimple($filename){

        $striped_content = '';
        $content = '';

        if(!$filename || !file_exists($filename)) return false;

        $zip = zip_open($filename);
        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            $path = zip_entry_name($zip_entry);
            $filename = pathinfo($path, PATHINFO_FILENAME);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filesize = zip_entry_filesize($zip_entry);
            $entryContents = zip_entry_read($zip_entry, $filesize);

            if ($path == "docProps/custom.xml") {
//                d($entryContents);
            }
            if ($path == "word/document.xml")
            {
                $content .= $entryContents;
            }


            if (preg_match('([^\s]+(\.(?i)(jpg|jpeg|png|gif|bmp))$)', $path))
            {

               $storagePath = sys_get_temp_dir().'/wordimage_'.Carbon::now()->timestamp.'_'.$filename.'.'.$extension;

                \File::put($storagePath, $entryContents, $filesize);
                $this->images->push($storagePath);
            }

            zip_entry_close($zip_entry);
        }
        zip_close($zip);

        $xmlfilename = sys_get_temp_dir().'/'.str_random(16).'.xml';
        \File::put($xmlfilename, $content);
        return $this->readDocxContent($xmlfilename);
    }

    public function readDocx($path)
    {
        $phpword = IOFactory::load($path);
    }

    public function import()
    {
        $extension = pathinfo($this->filePath, PATHINFO_EXTENSION);

        if ($extension == 'docx')
            return $this->readDocxSimple($this->filePath);

        throw new FiletypeNotSupportedException('The file type ' . $extension . ' is not supported.');

    }

    public function insertImagesInBody($html, $images)
    {
        $dom = DOMQuery::create('<div>'.$html.'</div>');
        foreach($images as $image)
        {
            $url = $this->assetStorage->getUrlForAsset($image);
            $htmlToAdd = "<img src='{$url}' class='img img-responsive' />\n";
            $dom->append($htmlToAdd);
        }
        $this->html = $dom->getHtml();

        return $this;
    }

    public function getCourse(Client $client, $courseName)
    {
        // Initialize variables.
        /*
         * Final Result:
         * - Course
         *   + Description (between top of file and modules 1
         *   - Modules (Split by Module #: ...)
         *     - Articles (Modules split by slides)
         */
        $body = DOMQuery::create($this->getHtml())->find('body');

        $moduleReg = '/<p>Module\s(\d{1,3}):(.*)<\/p>/';
        preg_match_all($moduleReg, $body, $result, PREG_OFFSET_CAPTURE);

        $moduleIndexes = $result[0];
        $moduleNumbers  = $result[1];
        $moduleTitles = $result[2];

        $descriptionBody = substr($body, 0, $result[0][0][1]);

        $modules = [];

        foreach($moduleIndexes as $key => $indexArray) {
            $startIndex = $indexArray[1] + strlen($indexArray[0]);
            $endIndex = ($key+1 < count($moduleIndexes)) ? $moduleIndexes[$key+1][1] : strlen($body);
            $number = $moduleNumbers[$key][0];
            $title = trim($moduleTitles[$key][0]);

            $moduleBody = substr($body, $startIndex, $endIndex - $startIndex);

            $articles = $this->getArticlesFromModuleHtml($moduleBody);

            $modules[] = [
                'name' => $title,
                'number' => $number,
                'articles' => $articles
            ];

        }

        $course = $client->courses()->create([
            'name' => $courseName,
            'description' => $descriptionBody
        ]);

        foreach($modules as $moduleArray) {
            $module = $course->modules()->create([
                'name' => $moduleArray['name'],
                'number' => $moduleArray['number'],
                'client_id' => $client->id,
            ]);
            if (!empty($moduleArray['articles']) && is_array($moduleArray['articles'])) {
                foreach($moduleArray['articles'] as $article) {
                    $module->articles()->create([
                        'name' => $article['name'],
                        'body' => $article['body'],
                        'number' => $article['number'],
                        'client_id' => $client->id
                    ]);
                }
            }

        }

        $course->load('modules.articles');

        return $course;

    }

    public function getArticlesFromModuleHtml($body)
    {
        $slideReg = '/<p>Slide(s?)\s(\d{1,2})(\s?(&amp;)?\s?)(\d{0,2})(.*?)<\/p>/';
        $slideReg = '/<p>.*Slide(s?) (\d{1,3}):(.*)(<\/.>)*/';
        preg_match_all($slideReg, $body, $result, PREG_OFFSET_CAPTURE);

        $articleIndexes = $result[0];
        $articleNumbers  = $result[1];
        $articleTitles = $result[3];

        $descriptionBody = substr($body, 0, $result[0][0][1]);

        $articles = [];
        $patterns = [
            '/<p>TBD.*/',
            '/<p>Lead SME Notes:.*/',
            '/<p>Survey Question(s?):.*/',
            '/<p>Skills Evaluation:.*/',
            '/<p>Programming Note(s?).*/',
            '/<p>Listen.*/',
            '/<p>Instructor Notes.*/',
            '/<p>Do.*/',
            '/<p>Answer.*/',
            '/<p>Watch.*/',
            '/<p>\s*?<\/p>/',

        ];



        foreach($articleIndexes as $key => $indexArray)
        {
            $startIndex = $indexArray[1] + strlen($indexArray[0]);
            $endIndex = ($key+1 < count($articleIndexes)) ? $articleIndexes[$key+1][1] : strlen($body);
            $number = $articleNumbers[$key][0];
            $title = trim($articleTitles[$key][0]);
            $title = str_replace('</p>', '', $title);
            $title = str_replace('</strong>', '', $title);

            $articleBody = substr($body, $startIndex, $endIndex - $startIndex);

            $articleBodyArray = explode("\n", $articleBody);
            foreach($articleBodyArray as $bKey => $line)
            {
                foreach($patterns as $reg)
                {
                    if (preg_match($reg, $line)) unset($articleBodyArray[$bKey]);
                }
            }
            $articleBody = implode("\n", $articleBodyArray);
            $articles[] = [
                'name' => $title,
                'number' => $key+1,
                'body' => $articleBody
            ];
        }

        return $articles;
    }

    public function getSlides()
    {



        // Initialize variables.
        $slides = [];
        $resetSlide = function() {
            return [
                'title' => '',
                'number' => '',
                'content' => '',
                'position' => '',
            ];
        };
        $slide = $resetSlide();

        // // Extract slides from HTML code (old version).
        // $body = DOMQuery::create($this->getHtml())->find('body');
        // $bodyArray = preg_split('/<p>Slide(s?)\s(\d\d?)(.*?)<\/p>/', $body, -1, PREG_SPLIT_DELIM_CAPTURE);
        //
        // foreach($bodyArray as $partial)
        // {
            // //If the partial is
            // if ($partial == '')
            // {
                // if (!empty($slide['title']))
                    // $slides[] = $slide;
                // $slide = $resetSlide();
            // }elseif (is_numeric($partial) && $slide['number'] == '')
            // {
                // $slide['number'] = $partial;
            // }elseif (!empty($slide['number']) && empty($slide['title'])) {
                // $slide['title'] = htmlspecialchars_decode($partial);
            // }elseif (!empty($slide['number']) && !empty($slide['title'])) {
                // $slide['content'] = $partial;
            // }
        // }

        // Extract slides from HTML code.
        $result = array();
        $body = DOMQuery::create($this->getHtml())->find('body');
        preg_match_all('/<p>Slide(s?)\s(\d{1,2})(\s?(&amp;)?\s?)(\d{0,2})(.*?)<\/p>/', $body, $result, PREG_OFFSET_CAPTURE);
        $indexes = $result[0];
        $titles = $result[6];
        $number1 = $result[2];
        $number2 = $result[5];

        for($i=0; $i<count($indexes); $i++)
        {
            $slide = $resetSlide();
            $slide['title'] = $titles[$i][0];
            $slide['position'] = $i + 1;
            $slide['number'] = strlen($number2[$i][0] <= 0) ? $number1[$i][0] : ($number1[$i][0] . ' &amp; ' . $number2[$i][0]);

            $startIndex = $indexes[$i][1] + strlen($indexes[$i][0]);
            $endIndex = ($i + 1 < count($indexes)) ? $indexes[$i + 1][1] : strlen($body);
            $slide['content'] = substr($body, $startIndex, $endIndex - $startIndex);

            array_push($slides, $slide);
        }

        // Extract slides from HTML code.
        $result = array();
        $body = DOMQuery::create($this->getHtml())->find('body');
        preg_match_all('/<p>Slide(s?)\s(\d{1,2})(\s?(&amp;)?\s?)(\d{0,2})(.*?)<\/p>/', $body, $result, PREG_OFFSET_CAPTURE);
        $indexes = $result[0];
        $titles = $result[6];
        $number1 = $result[2];
        $number2 = $result[5];

        for($i=0; $i<count($indexes); $i++) {
            $slide = $resetSlide();
            $slide['title'] = $titles[$i][0];
            $slide['position'] = $i + 1;
            $slide['number'] = strlen($number2[$i][0] <= 0)? $number1[$i][0] : ($number1[$i][0] . ' &amp; ' . $number2[$i][0]);

            $startIndex = $indexes[$i][1] + strlen($indexes[$i][0]);
            $endIndex = ($i+1 < count($indexes))? $indexes[$i+1][1] : strlen($body);
            $slide['content'] = substr($body, $startIndex, $endIndex - $startIndex);

            array_push($slides, $slide);
        }

        // Remove Facilitator notes from slides
        foreach($slides as &$slide)
        {
            $contentArray = preg_split('/<p>Facilitator Note(s?): <\/p>/', $slide['content'], -1, PREG_SPLIT_DELIM_CAPTURE);
            $slide['content'] = $contentArray[0];
        }

        return $slides;
    }

    public function getArticlesForModule(Module $module)
    {
        $slides = $this->getSlides();
        foreach($slides as $slide)
        {
            $article = $module->articles()->create([
                'client_id' => $module->client_id,
                'name' => $slide['title'],
                'body' => $slide['content']
            ]);
        }

        $module->load('articles');

        return $module->articles;
    }


}