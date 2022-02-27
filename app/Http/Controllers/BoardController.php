<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoardController extends Controller
{
    public function index (){
        $board = Board::all();
        $category = Category::all();
        return view('admin.board.index', compact('board','category'));
    }
    
    public function add (){
        $category = Category::all();
        return view('admin.board.add' ,compact('category'));
    }

    public function insert (Request $request ){
        $board = new Board();
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $exten = $file->getClientOriginalExtension();
            $filename = time().'.'.$exten;
            $file->move('assets/uploads/board',$filename);
            $board->image = $filename;
        }

        $board->cat_id = $request->input('cat_id');
        $board->name = $request->input('name');
        $board->brief = $request->input('brief');
        $board->price = $request->input('price');
        $board->description = $request->input('description');
        $board->stock = $request->input('stock');
        $board->save();
        return redirect('/boards')->with('status' , "board Added Successfully!!!");
    }

    public function edit($id){
        $board = Board::find($id);
        $category = Category::all();
        return view('admin.board.edit', compact('board','category'));
    }

    public function update(Request $request ,$id){
        $board = Board::findOrFail($id);
        if($request->hasFile('image'))
        {
            $path = '/assets/uploads/board/'.$board->image;
            if(file_exists($path))
            {
                Storage::disk('local')->delete($path);
            }
            $file = $request->file('image');
            $exten = $file->getClientOriginalExtension();
            $filename = time().'.'.$exten;
            $file->move('assets/uploads/board',$filename);
            $board->image = $filename;
        }
        $board->cat_id = $request->input('cat_id');
        $board->name = $request->input('name');
        $board->brief = $request->input('brief');
        $board->price = $request->input('price');
        $board->description = $request->input('description');
        $board->stock = $request->input('stock');
        $board->update();
        return redirect('/boards')->with('success', 'board Updated!');
    }

    public function destroy($id){
        $board = Board::find($id);
        if($board->image)
        {
            $path = 'assets/uploads/board'.$board->image;
            if(file_exists($path))
            {
                Storage::disk('local')->delete($path);
            }
        }
        $board->delete();
        return redirect('/boards')->with('success', 'Deleted Successfully!');
    }
}
