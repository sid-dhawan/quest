<?
//Creates an inverted index of the crawed documents
//An inverted index (also referred to as postings file or inverted file) is an index data structure storing a mapping from content, such as words or numbers, to its locations (The URLs in this situation).
require("simple_html_dom.php");
require("content-compare.php");
$conn = new mysqli("localhost","root","meetsid20","Search_Engine");
//Indexer code goes here
$conn->close();
?>