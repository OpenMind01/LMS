<?php
/**
 * Created by Justin McCombs.
 * Date: 10/12/15
 * Time: 11:20 AM
 */
namespace Pi\Snippets\Interfaces;

interface SnippetServiceInterface
{
    /**
     * Processes a piece of text for shortcodes, using the supplied variables.
     *
     * @param $text         The piece of text to process
     * @param $viewData     Must be an arrayable interface.
     * @return mixed
     */
    public function process($text, $viewData);

    /**
     * Returns a collection of snippet instances based on the text given.
     *
     * @param $text
     * @return mixed
     */
    public function getSnippetsFromText($text);

    /**
     * Returns an instance of a snippet based on the shortcode supplied
     *
     * @param $shortcode
     * @return mixed
     */
    public function getSnippetByShortcode($shortcode);

    /**
     * Renders a snippet based on the data supplied
     *
     * @param SnippetInterface $snippet             The snippet to be rendered
     * @param UsedInSnippetsInterface $instance     The main instance of the snippet
     * @param array $data                           Any extra data
     * @return mixed
     */
    public function render(SnippetInterface $snippet, UsedInSnippetsInterface $instance, $data = []);
}