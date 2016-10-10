<?php

namespace Pi\Console\Commands;

use Illuminate\Console\Command;
use Pi\Clients\Client;
use Faker\Factory as Faker;
use Pi\Clients\Courses\Course;
use Pi\Clients\Courses\Quizzes\ElementTypes\TextQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\SelectQuestion;
use Pi\Clients\Courses\Quizzes\ElementTypes\CheckboxQuestion;

class GenerateQuizzesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:quizzes {--clientId=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Dummy Quizzes for client';

    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->faker = Faker::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client  = $this->getClient();
        $this->client = $client;

        $course = $this->getCourse();

        $numberOfQuestions = $this->ask('How many questions per Article?');

        foreach($course->modules as $module) {
            foreach($module->articles as $article) {
                $this->createQuizzesForArticle($client, $course, $module, $article, $numberOfQuestions);
            }
        }

        $this->info('Done!');
    }



    public function getClient()
    {
        $clientId = $this->option('clientId');

        if ( ! $clientId ) {
            $clients = Client::all();
            foreach($clients as $client) { $this->info($client->id. '. ' . $client->name); }
            $clientId = $this->ask('Which Client are we generating quizzes for?');
        }

        $client = Client::find($clientId);
        if ( ! $client ) {
            $this->error('Could not find a client with that id.');
            exit;
        }
        return $client;
    }

    /**
     * @param $client
     * @param $course
     * @param $module
     * @param $article
     * @param int $count
     */
    protected function createQuizzesForArticle($client, $course, $module, $article, $count=5)
    {
        // Generate a quiz
        $quiz = $article->quizzes()->where('type', '=', 1)->first();
        if ( ! $quiz ) {
            $quiz = $article->quizzes()->create([
                'client_id' => $client->id,
                'created_by' => 1,
                'type' => 1,
                'name' => 'Test Quiz',
                'description' => 'This is a test quiz description.  In this quiz you will learn about everything.'
            ]);
        }


        $questions = [];
        $chkTypeId = (new CheckboxQuestion())->getTypeId();
        $selTypeId = (new SelectQuestion())->getTypeId();
        $textTypeId = (new TextQuestion())->getTypeId();
        $types = [
            (new CheckboxQuestion())->getTypeId(),
            (new SelectQuestion())->getTypeId(),
            (new TextQuestion())->getTypeId(),
        ];
        while(count($questions) < $count) {
            $typeId = array_rand($types);

            if ($typeId == 0) continue;

            switch($typeId) {
                case $chkTypeId:
                    $answer = json_encode([1,2]);
                    $label = 'Answer is first 2';
                    break;

                case $selTypeId:
                    $answer = 2;
                    $label = 'Answer second selection';
                    break;

                case $textTypeId:
                    $answer = $this->faker->word;
                    $label = $this->faker->paragraph.'<br />Answer is '.$answer;
                    break;
            }

            $isText = ($typeId == (new TextQuestion)->getTypeId());

            $q = $quiz->elements()->create([
                'client_id' => $client->id,
                'type' => $typeId,
                'label' => $label,
                'answer' => $answer,
                'number' => count($questions)+1,
            ]);
            if (!$isText) {
                foreach(range(1,5) as $i) {
                    $q->options()->create(['label' => $this->faker->word, 'value' => $i, 'client_id' => $client->id]);
                }
            }
            $questions[] = $q;
        }
    }

    public function getCourse()
    {
        $courses = $this->client->courses;
        foreach($courses as $course) { $this->info("{$course->id}. {$course->name}"); }
        $courseId = $this->ask('Which course id are we generating quizzes for?');
        $course = Course::find($courseId);
        if ( ! $course ) {
            $this->error('Course not found.');
            exit;
        }
        return $course;
    }
}
