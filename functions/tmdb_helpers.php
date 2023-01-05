<?php
use Classes\Router;

# TMDB helper function, Loads data from the TMDB API.
function searchByMovieTitle($urlOfJsonApi){
	$id = $title = $releaseDate = [];
	$currentPage = $totalPages = $totalResults = $results = '';
	if(Router::get_file_contents_curl($urlOfJsonApi)){
		$urlOfJsonApi = Router::get_file_contents_curl($urlOfJsonApi);
		if(json_decode($urlOfJsonApi)){
			$jsonObj = json_decode($urlOfJsonApi);

			if(isset($jsonObj->page)){
				$currentPage = $jsonObj->page;
			}

			if(isset($jsonObj->total_pages)){
				$totalPages = $jsonObj->total_pages;
			}

			if(isset($jsonObj->total_results)){
				$totalResults = $jsonObj->total_results;
			}

			if(isset($jsonObj->results)){
				$results = $jsonObj->results;
				foreach($results as $key => $value){
					$id[] = $results[$key]->id;
					$title[] = $results[$key]->title;
					$releaseDate[] = $results[$key]->release_date;
				}
			}

			return $allResults = ['current_page' => $currentPage, 'total_pages' => $totalPages, 'total_results' => $totalResults, 'id' => $id, 'title' => $title, 'release_date' => $releaseDate];
		}
		return "Error found on Json file, cannot decode file.";
	}
	return "File does not exist.";
}

function getMovieDetails($urlOfJsonApi){
	$adult = $backdrop_path = $budget = $genre = $homepage = $imdb_id = $original_language = $original_title = $overview = $poster_path = $production_company = $release_date = $revenue = $runtime = $status = $title = $vote_average = $vote_count = $video = '';
	if(Router::get_file_contents_curl($urlOfJsonApi)){
		$urlOfJsonApi = Router::get_file_contents_curl($urlOfJsonApi);
		if(json_decode($urlOfJsonApi)){
			$jsonObj = json_decode($urlOfJsonApi);

			if(isset($jsonObj->adult)){
				$adult = $jsonObj->adult;
			}
			if(isset($jsonObj->backdrop_path)){
				$backdrop_path = $jsonObj->backdrop_path;
			}
			if(isset($jsonObj->budget)){
				$budget = $jsonObj->budget;
			}
			if(isset($jsonObj->homepage)){
				$homepage = $jsonObj->homepage;
			}
			if(isset($jsonObj->imdb_id)){
				$imdb_id = $jsonObj->imdb_id;
			}
			if(isset($jsonObj->original_language)){
				$original_language = $jsonObj->original_language;
			}
			if(isset($jsonObj->original_title)){
				$original_title = $jsonObj->original_title;
			}
			if(isset($jsonObj->overview)){
				$overview = $jsonObj->overview;
			}
			if(isset($jsonObj->poster_path)){
				$poster_path = $jsonObj->poster_path;
			}
			if(isset($jsonObj->release_date)){
				$release_date = $jsonObj->release_date;
			}
			if(isset($jsonObj->revenue)){
				$revenue = $jsonObj->revenue;
			}
			if(isset($jsonObj->runtime)){
				$runtime = $jsonObj->runtime;
			}
			if(isset($jsonObj->status)){
				$status = $jsonObj->status;
			}
			if(isset($jsonObj->title)){
				$title = $jsonObj->title;
			}
			if(isset($jsonObj->vote_average)){
				$vote_average = $jsonObj->vote_average;
			}
			if(isset($jsonObj->vote_count)){
				$vote_count = $jsonObj->vote_count;
			}

			if(isset($jsonObj->genres)){
				$genres = $jsonObj->genres;
				foreach($genres as $key => $value){
					$genre .= $genres[$key]->name." * ";
				}
				$genre = rtrim($genre, ' * ');
			}

			if(isset($jsonObj->production_companies)){
				$production_companies = $jsonObj->production_companies;
				foreach($production_companies as $key => $value){
					$production_company .= $production_companies[$key]->name.", ";
				}
				$production_company = rtrim($production_company, ', ');
			}

			if(isset($jsonObj->videos->results)){
				$videos = $jsonObj->videos->results;
				foreach($videos as $key => $value){
					$site = strtolower($videos[$key]->site);
					if($site === 'youtube'){
						$video .= $videos[$key]->key." * ";
					}
				}
				$video = rtrim($video, ' * ');
			}

			return $results = [$adult, $backdrop_path, $budget, $genre, $homepage, $imdb_id, $original_language, $original_title, $overview, $poster_path, $production_company, $release_date, $revenue, $runtime, $status, $title, $vote_average, $vote_count, $video];
		}
		return "Error found on Json file, cannot decode file.";
	}
	return "File does not exist.";
}
