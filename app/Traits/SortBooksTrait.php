<?php

namespace App\Traits;
use App\Models\Comment;

trait SortBooksTrait {

	public function sortBooks($data, $key, $order_type = 'desc', $filter = []) {
	    if(count($data) < 2) {
	        return $data;
	    }

	    // split array into 2
	    $first_array = array_slice($data, 0, ceil(count($data)/2));
	    $second_array = array_slice($data, count($first_array), floor(count($data)/2));

	    $first = $this->sortBooks($first_array, $key, $order_type, $filter);
	    $second = $this->sortBooks($second_array, $key, $order_type, $filter);

	    return $this->mergeArray($first, $second, $key, $order_type, $filter);
	}

	public function mergeArray($first, $second, $key, $order_type, $filter) {
	    $c = [];

	    while(count($first) > 0 && count($second) > 0) {
	    	if($order_type == 'desc') {
		    	if($first[0][$key] > $second[0][$key]) {
					$new_second = array(
		            	'name' => $second[0]['name'],
		            	'authors' => $second[0]['authors'],
		            	'released' => $second[0]['released'],
		            	'comments' => Comment::where('name', $second[0]['name'])->count()
		            );

		            array_push($c, $new_second);
		            $second = array_slice($second, 1);
		        } else {
		        	$new_first = array(
		            	'name' => $first[0]['name'],
		            	'authors' => $first[0]['authors'],
		            	'released' => $first[0]['released'],
		            	'comments' => Comment::where('name', $first[0]['name'])->count()
		            );
		            array_push($c, $new_first);
		            $first = array_slice($first, 1);
		        }
		    } else {
		    	if($first[0][$key] < $second[0][$key]) {
					$new_second = array(
		            	'name' => $second[0]['name'],
		            	'authors' => $second[0]['authors'],
		            	'released' => $second[0]['released'],
		            	'comments' => Comment::where('name', $second[0]['name'])->count()
		            );

		            array_push($c, $new_second);
		            $second = array_slice($second, 1);
		        } else {
		        	$new_first = array(
		            	'name' => $first[0]['name'],
		            	'authors' => $first[0]['authors'],
		            	'released' => $first[0]['released'],
		            	'comments' => Comment::where('name', $first[0]['name'])->count()
		            );

		            array_push($c, $new_first);
		            $first = array_slice($first, 1);
		        }
		    }
	    }

	    while(count($first) > 0) {
	    	$new_first = array(
            	'name' => $first[0]['name'],
            	'authors' => $first[0]['authors'],
            	'released' => $first[0]['released'],
            	'comments' => Comment::where('name', $first[0]['name'])->count()
            );

	        array_push($c, $new_first);
	        $first = array_slice($first, 1);
	    }

	    while(count($second) > 0){
	    	$new_second = array(
            	'name' => $second[0]['name'],
            	'authors' => $second[0]['authors'],
            	'released' => $second[0]['released'],
            	'comments' => Comment::where('name', $second[0]['name'])->count()
            );
	        array_push($c, $new_second);
	        $second = array_slice($second, 1);
	    }

	    return $c;
	}	
}