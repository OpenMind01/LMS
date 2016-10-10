<?php
/**
 * Created by Justin McCombs.
 * Date: 10/12/15
 * Time: 10:47 AM
 */

namespace Pi\Snippets;


use Illuminate\Support\Collection;
use Pi\Auth\User;
use Pi\Snippets\Interfaces\ProvidesDynamicSnippetsInterface;
use Pi\Snippets\Interfaces\SnippetInterface;
use Pi\Snippets\Interfaces\SnippetServiceInterface;
use Pi\Snippets\Interfaces\UsedInSnippetsInterface;
use Pi\Snippets\Types\StaticType\Client\ClientNameSnippet;
use Pi\Snippets\Types\Dynamic\DynamicSnippet;
use Pi\Snippets\Types\StaticType\User\UserFirstNameSnippet;
use Pi\Snippets\Types\StaticType\User\UserRolesListSnippet;
use Symfony\Component\Finder\SplFileInfo;

class SnippetService implements SnippetServiceInterface
{

    protected $snippetClasses = [
        ClientNameSnippet::class,
        UserFirstNameSnippet::class,
        UserRolesListSnippet::class,
    ];

    protected $snippets;

    protected $dynamicSnippets;

    public function __construct()
    {
        $this->snippets = new Collection;
        $this->dynamicSnippets = new Collection;

        $this->registerDirectory(__DIR__.'/Types/StaticType');
//        foreach($this->snippetClasses as $classname)
//        {
//            $this->snippets->push(new $classname);
//        }

        if ( \Auth::user() )
        {
            $this->snippets = $this->snippets->merge($this->getDynamicSnippetsForUser(\Auth::user()));
        }
    }

    public function registerDirectory($directory)
    {
        foreach(\File::allFiles($directory) as $filename) {
            if (\File::isDirectory($filename)) {
                $this->registerDirectory($filename);
            }else {
                $this->registerSnippetClass($filename);
            }
        }
    }
    public function registerSnippetClass(SplFileInfo $filename)
    {
        $className = 'Pi\\'.str_replace(app_path().DIRECTORY_SEPARATOR, '', $filename->getPath()).DIRECTORY_SEPARATOR.str_replace('.php', '', $filename->getFilename());
        $className = str_replace('/', '\\', $className);
        $this->snippets->push(\App::make($className));
    }

    public function registerSnippetsFromInstance(ProvidesDynamicSnippetsInterface $instance)
    {
        $this->dynamicSnippets->push($instance->getSnippetsForUser(\Auth::user()));
    }

    public function getPattern($shortCode)
    {
        return '/\{'.$shortCode.'\}/';
    }

    /**
     * Processes a piece of text for shortcodes, using the supplied variables.
     *
     * @param $text         The piece of text to process
     * @param $viewData     Must be an arrayable interface.
     * @return mixed
     */
    public function process($text, $viewData)
    {
        $snippets = $this->getSnippetsFromText($text);
        foreach($snippets as $snippet)
        {
            $pattern = $this->getPattern($snippet->getShortcode());
            if ($snippet->getInstance() && $snippet->getValue()) {
                $text = preg_replace($pattern, $snippet->getValue(), $text);
            }else {
                foreach($viewData as $instance)
                {
                    if ( ! is_object($instance) ) continue;
                    if (get_class($instance) == $snippet->getClass())
                    {
                        $replacement = $this->render($snippet, $instance, $viewData);
                        $text = preg_replace($pattern, $replacement, $text);
                    }

                }
            }

        }

        return $text;
    }

    /**
     * Returns a collection of snippet instances based on the text given.
     *
     * @param $text
     * @return mixed
     */
    public function getSnippetsFromText($text)
    {
        $snippets = new Collection();

        foreach($this->snippets as $snippet)
        {
            if (strpos($text, $snippet->getShortcode()) !== false)
                $snippets->push($snippet);
        }

        return $snippets;
    }

    /**
     * Returns an instance of a snippet based on the shortcode supplied
     *
     * @param $shortcode
     * @return mixed
     */
    public function getSnippetByShortcode($shortcode)
    {
        foreach($this->snippets as $snippet)
        {
            if ($snippet->getShortcode() == $shortcode)
                return $snippet;
        }

        return null;
    }

    /**
     * Renders a snippet based on the data supplied
     *
     * @param SnippetInterface $snippet             The snippet to be rendered
     * @param UsedInSnippetsInterface $instance     The main instance of the snippet
     * @param array $data                           Any extra data
     * @return mixed
     */
    public function render(SnippetInterface $snippet, UsedInSnippetsInterface $instance, $data = [])
    {


        foreach($data as $dataInstance)
        {
            if ( ! is_object($dataInstance) || ! in_array(UsedInSnippetsInterface::class, class_implements($dataInstance)))
            {
                continue;
            }
            foreach($snippet->getRequiredKeys() as $keyName => $class)
            {
                if (get_class($dataInstance) == $class) {
                    $snippet->set($keyName, $dataInstance);
                }
            }
        }

        $value = $snippet->setInstance($instance)->getValue();

        if ( $snippet->shouldEscapeValue() ) {
            $value = e($value);
        }

        return $value;

    }

    /**
     * Returns the snippets available with the classnames provided
     *
     * @param $classNames
     * @return Collection
     */
    public function getAvailableSnippets($classNames)
    {
        $availableSnippets = new Collection;

        /** @var \Pi\Snippets\Interfaces\SnippetInterface $snippet */
        foreach($this->snippets as $snippet)
        {
            // Get all required classes form the snippet -- this will be the main class,
            // plus any additional required keys.
            $requiredClasses = [$snippet->getClass()];
            $keys = $snippet->getRequiredKeys();
            if ($keys  && is_array($keys))
                $requiredClasses = array_merge([$snippet->getClass()], $snippet->getRequiredKeys());

            // If all of the required keys exist in the provided classnames,
            // add the snippet to the return array
            if (array_intersect($requiredClasses, $classNames) === $requiredClasses) {
                $availableSnippets->push($snippet);
            }
        }

//        $availableSnippets = $availableSnippets->merge($this->getDynamicSnippetsForUser(\Auth::user()));

        return $availableSnippets;
    }

    public function getDynamicSnippetsForUser(User $user)
    {
        // Get Room Attributes Snippets
        $dynamicSnippets = new Collection;

        if ($user->room) {
            foreach($user->room->roomAttributes as $attribute)
            {
                if ( !$attribute->snippet_key) continue;
                $snippet = new DynamicSnippet();
                $snippet->setInstance($attribute)
                    ->setShortCode('user.room.attributes.'.$attribute->snippet_key)
                    ->setValue($attribute->value)
                    ->setDescription($attribute->name);
                $dynamicSnippets->push($snippet);
            }
        }
        return $dynamicSnippets;
    }
}