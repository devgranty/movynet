<?php

# Input sanitizers, sanitizes input types.
function sanitize_input($input){
	return htmlentities($input, ENT_QUOTES, 'UTF-8');
}

function sanitize_email($input){
	return filter_var($input, FILTER_SANITIZE_EMAIL);
}

function sanitize_int($input){
	return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}
