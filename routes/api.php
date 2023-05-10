<?php

use App\Http\Controllers\GameController;
use App\RMVC\Route\Route;

Route::get("api/game/new", [GameController::class, 'create']);
Route::get("api/game/status", [GameController::class, 'status']);
Route::post("api/game/move", [GameController::class, 'makeMove']);
