<?php

namespace App\Http\Controllers;

use DB;
use App\Reply;
use App\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function store(Reply $reply)
	{
		$reply->favorite( auth()->id() );
		return back();
	}
	public function destroy(Reply $reply)
	{
		$reply->unfavorite( auth()->id() );
		// return back();
	}
}
