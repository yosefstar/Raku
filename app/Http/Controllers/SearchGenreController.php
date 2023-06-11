<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RakutenRws_Client; // RakutenRws_Clientのクラスを使用する場合、適切な名前空間を指定する必要があります

class SearchGenreController extends Controller
{
    // public function index()
    // {

    //     $client = new RakutenRws_Client();
    //     $client->setApplicationId('1070684823768079421');

    //     $response = $client->execute('IchibaGenreSearch', array(
    //         'genreId' => 0
    //     ));

    //     if ($response->isOk()) {

    //         foreach ($response['children'] as $childGenre) {
    //             $genre = $childGenre['child'];
    //             // ジャンル名を出力します
    //             echo $genre['genreName'] . "\n";
    //         }
    //     } else {
    //         // getMessage() でレスポンスメッセージを取得することができます
    //         echo 'Error:' . $response->getMessage();
    //     }
    // }
    public function index(Request $request)
    {
        $genreName = '';

        if ($request->has('genreId')) {
            $genreId = $request->input('genreId');

            $client = new RakutenRws_Client();
            $client->setApplicationId('1070684823768079421');

            $response = $client->execute('IchibaGenreSearch', [
                'genreId' => $genreId,
            ]);

            if ($response->isOk()) {
                $parents = $response['parents'];

                if (count($parents) > 0) {
                    $genre = $parents[0]['parent'];
                    $genreName = $genre['genreName'];
                }
            } else {
                $errorMessage = 'Error: ' . $response->getMessage();
                return response()->json(['error' => $errorMessage]);
            }

            return response()->json(['genreName' => $genreName]);
        }

        return response()->json(['error' => 'Genre ID not provided']);
    }
}
