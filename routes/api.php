<?php

use App\Answer;
use App\Project;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/login', static function (Request $request) {
    return response()->json(['error' => 'Not authorized.'],403);
})->name('api.login');

Route::post('/login', static function (Request $request) {
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
        $user = Auth::user();
        $user->api_token = Str::random(60);
        $user->save();
        return response()->json(['success' => true, 'token' => $user->api_token]);
    }
    else{
        return response()->json(['success'=> false]);
    }
});

Route::get('/quiz/{hash}', static function (Request $request, $hash) {
    $project = Project::whereHash($hash)->first();
    if($project === null) {
        return response()->json(['success'=> false]);
    }

    return response()->json([
        'success' => true,
        'quiz' => [
            'project' => $project,
            'questions' => Question::get()
        ]
    ]);
});

Route::post('/answers', static function (Request $request) {

    $validationRules = [
        'name' => 'required',
        'role' => 'required',
        'project_id' => 'required|exists:projects,id'
    ];

    $questions = Question::get();

    foreach ($questions as $question) {
        $validationRules['question'.$question->id] = $question->is_free_text ? 'required' : 'required|integer|between:1,10';
    }

    $validator = Validator::make($request->all(), $validationRules);

    if(!$validator->fails()) {

        $answer = new Answer();
        $answer->name = $request->input('name');
        $answer->role = $request->input('role');
        $answer->project_id = $request->input('project_id');
        $answer->save();

        foreach ($questions as $key => $question) {
            $answer->questions()->attach($question->id, ['value' => $request->input('question'.$question->id)]);
        }

        return response()->json(['success' => true]);
    }
    else{
        return response()->json(['success'=> false, 'motive' => $validator->errors()]);
    }
});

Route::middleware('auth:api')->get('/dashboard', static function (Request $request) {
    return response()->json(['success' => true, 'dashboard' => [$request->user()]]);
});
