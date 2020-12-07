<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Column;
use App\Models\Card;
use \Spatie\DbDumper\Databases\MySql;
class BoardController extends Controller
{
    //
    public function getBoard() {
        // echo "Getting Board!";
        $columns = Column::all();

        foreach ($columns as $col) {
            $cards = array();
            $curr = $col['head_card'];
            while ($curr) {
                $card = Card::findOrFail($curr);
                array_push($cards, $card);
                $curr = $card['next'];
            }
            $col['cards'] = $cards;
        }
        return response()->json($columns, 200);
    }
    public function updateColumnTitle(Request $req) {
        /*
        updateColumnTitle data: {
            'id': some valid id
            'title': 'some Title for new column'
        }
        */
        $id = $req->input('id');
        $column = Column::findOrFail($id);
        $column['title'] = $req->input('title');
        $column->save();
        return response()->json($column, 200);
        
    }
    public function addColumn(Request $req) {
        /*
        addColumn data: {
            'title': 'some Title for new column'
        }
        */
        $column = new Column;
        $column['title'] = $req->input('title');
        $column['head_card'] = null;
        $column->save();
        // print_r($column);
        return response()->json($column, 201);
    }
    public function delColumn($id) {
        /* Delete req at /api/delete/{id} */
        $column = Column::find($id);
        $curr = $column['head_card'];
        while($curr) {
            $card = Card::find($curr);
            $curr = $card['next'];
            $card->delete();
        }
        // print_r($column);
        $column->delete();
        return response()->json([], 204);
    }
    public function addCard(Request $req) {
        /*
        addCard data: {
            'column_id': some valid column id
            'title': 'some Title for new column'
            'desc': 'some new description'
        }
        */
        $card = new Card;
        $card['title'] = $req->input('title');
        $card['desc'] = $req->input('desc');
        $card->save();
        $column = Column::findOrFail($req->input('column_id'));
        if ($column['head_card'] == null) {
            $column['head_card'] = $card['id'];
            $column->save();
        }
        else {
            $curr = $column['head_card'];
            $colCard = Card::find($curr);
            while ($curr) {
                $colCard = Card::find($curr);
                $curr = $colCard['next'];
            }
            $colCard['next'] = $card['id'];
            $card['prev'] = $colCard['id'];
            $colCard->save();
        }
        $card->save();
        return response()->json($card, 201);
    }
    public function updateCardItem(Request $req) {
        /*
        updateCardItem data: {
            'card_id': some valid card id
            'title': 'some Title for new column'
            'desc': 'some new description'
        }
        */
        $card = Card::findOrFail($req->input('card_id'));
        $card['title'] = $req->input('title');
        $card['desc'] = $req->input('desc');
        $card->save();
        return response()->json($card, 200);
    }
    public function updateCardLoc(Request $req) {
        /*
        updateCardLoc data: {
            'card_id': some valid column id
            'column_id': new valid column id for loc 
            'old_column_id': new valid column id for loc 
            'direction': can be "UP" or "DOWN" or "LEFT" or "RIGHT"
        }
        */
        $card = Card::findOrFail($req->input('card_id'));
        $dir = $req->input('direction');
        if ($dir == "UP") {
            // swap the cards
            $s_card = Card::findOrFail($card['prev']);

            $p = $s_card['prev'];
            $s = $s_card['id'];
            $c = $card['id'];
            $n = $card['next'];

            if ($p) {
                $p_card = Card::find($p);
                $p_card['next'] = $c;
                $p_card->save();
            }
            $card['prev'] = $p;
            $s_card['next'] = $n;
            if ($n) {
                $n_card = Card::find($n);
                $n_card['prev'] = $s;
                $n_card->save();
            }
            $card['next'] = $s;
            $s_card['prev'] = $c;
            $s_card->save();
            $card->save();
            // update the column head if needed
            $col = Column::findOrFail($req->input('old_column_id'));
            if ($col['head_card'] == $s_card['id']) {
                $col['head_card'] = $card['id'];
                $col->save();
            }
        }
        elseif ($dir == "DOWN") {
            // swap the cards
            $s_card = Card::findOrFail($card['next']);

            $p = $card['prev'];
            $c = $card['id'];
            $s = $s_card['id'];
            $n = $s_card['next'];

            if ($p) {
                $p_card = Card::find($p);
                $p_card['next'] = $s;
                $p_card->save();
            }
            $s_card['prev'] = $p;
            $card['next'] = $n;
            if ($n) {
                $n_card = Card::find($n);
                $n_card['prev'] = $c;
                $n_card->save();
            }
            $s_card['next'] = $c;
            $card['prev'] = $s;
            $s_card->save();
            $card->save();
            // update the column head if needed
            $col = Column::findOrFail($req->input('old_column_id'));
            if ($col['head_card'] == $card['id']) {
                $col['head_card'] = $s_card['id'];
                $col->save();
            }

        }
        elseif ($dir == "LEFT" || $dir == "RIGHT") {
            // remove it from the old column
            $old_col = Column::findOrFail($req->input('old_column_id'));
            if ($old_col['head_card'] == $card['id']) {
                $old_col['head_card'] = $card['next'];
                $old_col->save();
            }
            if ($card['prev']) {
                $t_card = Card::findOrFail($card['prev']);
                $t_card['next'] = $card['next'];
                $t_card->save();
            }
            if ($card['next']) {
                $t_card = Card::findOrFail($card['next']);
                $t_card['prev'] = $card['prev'];
                $t_card->save();
            }
            // move it to the new column
            $card['next'] = null;
            $card['prev'] = null;
            $column = Column::findOrFail($req->input('column_id'));
            if ($column['head_card'] == null) {
                $column['head_card'] = $card['id'];
                $column->save();
            }
            else {
                $curr = $column['head_card'];
                $colCard = Card::find($curr);
                while ($curr) {
                    $colCard = Card::find($curr);
                    $curr = $colCard['next'];
                }
                $colCard['next'] = $card['id'];
                $card['prev'] = $colCard['id'];
                $colCard->save();
            }
            $card->save();
        }
        else return response()->json([], 400);
        return response()->json($card, 200);
    }
    public function exportDB() {
        MySql::create()
            ->setDbName('laravel')
            ->setUserName('root')
            ->setPassword('password')
            ->dumpToFile('dump.sql');
    }


}
