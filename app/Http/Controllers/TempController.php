<?php

namespace Pi\Http\Controllers;

use Illuminate\Http\Request;
use Pi\Auth\User;
use Pi\Clients\Client;
use Pi\Clients\Courses\Quizzes\ElementTypes\CheckboxQuestion;
use Pi\Clients\Courses\Quizzes\QuizElement;
use Pi\Http\Requests;
use Pi\Http\Controllers\Controller;
use Pi\Importing\Word\WordImporter;
use Pi\Snippets\SnippetService;

class TempController extends Controller
{

    public function getIndex(SnippetService $snippets)
    {

        $text = "Hello, the current client is :client.name! Your name is :user.first_name, and you have the following roles: :user.roles";

        return $snippets->process($text, [
            Client::find(1),
            User::find(1),
        ]);
    }

    public function getTestFilesystem()
    {
        \Storage::disk('s3')->put('testfile.json', file_get_contents(base_path('composer.json')));
    }

    public function getTestWordImporting(WordImporter $wordImporter)
    {
        $file = storage_path('word.docx');

        //$text = $wordImporter->setFilePath($file)->getText();
        //d($wordImporter);
        //echo $text;

        $wordImporter->setFilePath($file);
        $wordImporter->import();
        
        //echo $wordImporter->getHtml();
        
        $slides = $wordImporter->getSlides();
        foreach($slides as $slide)
        {
            $name = strpos($slide['number'], '&')? 'Slides' : 'Slide';
            echo "<h2>" . $name . " " . $slide['number'] . ": " . $slide['title'] . "</h2>";
            echo $slide['content'];
        }
    }
    
    public function getTestQuizRendering()
    {
        $question = new CheckboxQuestion();
        /** @var QuizElement $element */
        $element = QuizElement::find(2);

        $element->save();

        return $question->render($element);
    }

    // TEMP: Temporary route for test the internal link feature.
    public function getArticles(Request $request, $clientSlug, $courseSlug, $moduleSlug) {
        // Get client, course and module.
        $client = Client::whereSlug($clientSlug)->first();
        $course = $client->courses()->whereSlug($courseSlug)->first();
        $module = $course->modules()->whereSlug($moduleSlug)->first();
        
        // Parse articles.
        $data = array();
        foreach($module->articles as $article) {
            // Define URL.
            $url = route('clients.courses.modules.articles.show', [
                'clientSlug' => $client->slug,
                'courseSlug' => $course->slug,
                'moduleSlug' => $module->slug,
                'articleNumber' => $article->number
            ]);
            
            // Add article to array.
            array_push($data, array(
                'name' => $article->name,
                'url' => $url
            ));
        }
     
        // Return result.
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
