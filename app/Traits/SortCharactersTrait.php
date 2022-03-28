<?php

namespace App\Traits;
use App\Models\Comment;

trait SortCharactersTrait {

	public function sortCharacters($data, $key, $order_type = 'desc', $filter = []) {
	    if(count($data) < 2) {
	        return $data;
	    }

	    // split array into 2
	    $first_array = array_slice($data, 0, ceil(count($data)/2));
	    $second_array = array_slice($data, count($first_array), floor(count($data)/2));

	    // call sortCharacters to each other
	    $first = $this->sortCharacters($first_array, $key, $order_type, $filter);
	    $second = $this->sortCharacters($second_array, $key, $order_type, $filter);

	    // merge the array you're comparing against in the mergeArray function
	    return $this->mergeArray($first, $second, $key, $order_type, $filter);
	}

	public function mergeArray($first, $second, $key, $order_type, $filter) {
	    $c = [];

	    while(count($first) > 0 && count($second) > 0) {
	    	// if ordering in a descending manner
	    	if($order_type == 'desc') {	
	    		// push array to c
	    		// also remove that first item that we handle after comparison
		    	if($first[0][$key] > $second[0][$key]) {
		            // push array to c
		            array_push($c, $second[0]);

		            // remove that
		            $second = array_slice($second, 1);
		        } else {
		            array_push($c, $first[0]);
		            $first = array_slice($first, 1);
		        }
		    // if ordering in a descending manner
		    } else {
		    	if($first[0][$key] < $second[0][$key]) {
		            array_push($c, $second[0]);
		            $second = array_slice($second, 1);
		        } else {
		            array_push($c, $first[0]);
		            $first = array_slice($first, 1);
		        }
		    }
	    }

	    // catch any array item that has no pair
	    while(count($first) > 0) {
	        array_push($c, $first[0]);
	        $first = array_slice($first, 1);
	    }

	    // catch any array item that has no pair
	    while(count($second) > 0){
	        array_push($c, $second[0]);
	        $second = array_slice($second, 1);
	    }

	    return $c;
	}	

	public function filterCharacters($data, $filter, $filter_value) {
		$new_data = [];
		$total_age = 0;

		foreach ($data as $value) {
			if($value[trim($filter)] == trim($filter_value)) {
				// add to new array
				array_push($new_data, $value);

				// add to total age. only make the addition if the data is there.
				if($value['born'] && $value['died']) {								
					$born = explode(' ', $value['born'])[1];
					$died = explode(' ', $value['died'])[1];

					$total_age = ($died - $born) + $total_age;
				}
			}
		}

		// return results
		return array(
			'data' => $new_data,
			'total_age' => $total_age
		);
	}
}