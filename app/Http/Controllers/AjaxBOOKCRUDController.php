<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\Book;
use Validator;

class AjaxBOOKCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    return view('ajax-book-crud');
      
    }
    /**
     * Show the form for fetch the specified resource.
     
     */
    public function fetchbook()
    {   

        $books = Book::all();

        return response()->json(['books'=>$books,]);
    }
   
    /**
     * Show the form for store the specified resource.
    
     */
  
   public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=> 'required',
            'code'=>'required',
            'author'=>'required',
           
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $book = new Book;
            $book->title = $request->input('title');
            $book->code = $request->input('code');
            $book->author = $request->input('author');
           
            $book->save();
            return response()->json([
                'status'=>200,
                'message'=>'Book Added Successfully.'
            ]);
        }

    }

    
    /**
     * Show the form for editing the specified resource.
     
     */
       public function edit($id)
       {
        $book=Book::where('id',$id)->first();
        if($book)
        {
             return response()->json([
                'status'=>200,
                'book'=> $book,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>400,
                'message'=>'No book Found',

            ]);
        }
       
       }

        /**
      Show the form for update the specified resource.
     */
    
  public function update(Request $request,$id)
   {
      $book = Book::find($id);
        if($book)
        {
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->code = $request->input('code');
        $book->update();
         return response()->json([
                    'status'=>200,
                    'message'=>'Bokk Updated Successfully.'
                ]);
            
        }
        else
        {
         return response()->json([
                    'status'=>400,
                    'message'=>'Book not found.'
                ]);
        }
     
  }
    
    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if($book)
        {
            $book->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Book Deleted Successfully.'
            ]);
           

        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No booK Found.'
            ]);
        }
    }
}