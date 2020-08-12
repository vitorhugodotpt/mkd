<?php

use App\Answer;
use App\Client;
use App\Project;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    $sql = 'SELECT questions.id, avg(answer_question.value) as value FROM answer_question LEFT JOIN questions ON questions.id=answer_question.question_id WHERE questions.is_free_text=0 GROUP BY questions.id;';
    $average = collect(DB::select($sql))
        ->map(static function($row) {
           return [
             'title' => Question::find($row->id)->name,
             'value' => number_format($row->value, 1, '.', ' ')
           ];
        });

    $averageClient = [];
    $projects = [];
    $totalProjects = 0;
    $clients = Client::get();
    foreach ($clients as $client) {
        $projectsID = $client->projects->pluck('id');
        $answersID = Answer::whereIn('project_id', $projectsID)->pluck('id');
        if(count($answersID) > 0) {
            $sql = 'SELECT questions.id, avg(answer_question.value) as value FROM answer_question LEFT JOIN questions ON questions.id=answer_question.question_id WHERE questions.is_free_text=0 AND answer_question.answer_id IN ('.implode(',', $answersID->toArray()).') GROUP BY questions.id;';
        }else {
            continue;
        }

        $data['title'] = $client->name;
        $data['data'] = collect(DB::select($sql))
            ->map(static function($row) {
                return [
                    'title' => Question::find($row->id)->name,
                    'value' => number_format($row->value, 1, '.', ' ')
                ];
            });

        $averageClient[] = $data;


        $data['data'] = $client->projects
            ->map(static function($row) {
                return [
                    'title' => $row->name
                ];
            });

        $totalProjects += count($data['data']);

        $projects[] = $data;
    }

    $questions = Question::where('is_free_text', 1)->get();
    foreach ($questions as $question) {

        $sql = 'SELECT questions.id,value FROM answer_question LEFT JOIN questions ON questions.id=answer_question.question_id WHERE questions.is_free_text=1;';
        $data['title'] = $question->name;
        $data['data']  = collect(DB::select($sql))
            ->map(static function($row) {
                return [
                    'title' => $row->value
                ];
            });

        $freeText[] = $data;
    }


    return response()->json([
        'success' => true,
        'dashboard' => [
                'average' => $average,
                'average_clients' => $averageClient,
                'free_text' => $freeText,
                'projects' => $projects,
                'total_projects' => $totalProjects
            ]
        ]);
});
