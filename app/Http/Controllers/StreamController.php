<?php

namespace App\Http\Controllers;

use JsonException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamController extends Controller
{
    private array $response;

    public function __construct()
    {
        $this->response = [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ];
    }


    /**
     * @throws JsonException
     */
    private function handleStream()
    {
        $projectController = new ProjectController();
        $this->createEvent('topTenLikes', $projectController->getTopTenLike());
        $this->createEvent('topTenLuck', $projectController->getTopTenLuck());
        $this->createEvent('generatedProjects', $projectController->getFiveRandomProjects());
        $this->createEvent('generatedLeader', $projectController->getRandomProject());

    }

    public function mainStream()
    {
        $callback = fn() => $this->handleStream();
        return $this->stream($callback, 1);
    }

    /**
     * @throws JsonException
     */
    private function createEvent($id, $data): void
    {
        $idObject = "id: $id" . PHP_EOL . PHP_EOL;
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        $dataObject = "data: $json" . PHP_EOL . PHP_EOL;
        echo "$idObject$dataObject";
        ob_flush();
        flush();
    }

    private function stream($callback): StreamedResponse
    {
        return response()->stream(function () use ($callback) {
            $callback();
        }, 200, $this->response);
    }

}
