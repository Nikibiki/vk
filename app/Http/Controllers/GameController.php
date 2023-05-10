<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\RMVC\App;
use App\Services\WikipediaService;
use App\Storage\Session\GameRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameController extends Controller
{
    private GameRepository $gameRepository;
    private WikipediaService $wikipediaService;

    public function __construct()
    {
        $this->gameRepository = new GameRepository();
        $this->wikipediaService = new WikipediaService();
    }
    
    public function create(): JsonResponse
    {
        $players = [];
        if (App::$request->jsonHas('players')) {

            foreach (App::$request->jsonGet('players') as $number => $player) {
                $playerObj = new Player($player['name'], $number + 1);
                $pages = $this->wikipediaService->getRandomPageId(2);
                $playerObj->setCurrentPageId($pages[0]);
                $playerObj->setTargetPageId($pages[1]);
                $players[] = $playerObj;
            }
        }
        $game = new Game($players);
        $this->gameRepository->save($game);

        return \jsonResponse()->setData(['data' => [
            'game' => $game,
        ]]);
    }

    /**
     * Возвращает состояние текущей игры
     * Игру ищем по id
     * Позволяет узнать, какой игрок ходу следующим и текущий счет
     * @return JsonResponse
     */
    public function status(): JsonResponse
    {
        return \jsonResponse()->setData([]);
    }

    /**
     *Игрок, который должен ходить, присылает свой ответ
     * Изменяем счет и устанавливаем игроку новую ссылку
     * @return JsonResponse
     */
    public function makeMove(): JsonResponse
    {
        return \jsonResponse()->setData([]);
    }
}