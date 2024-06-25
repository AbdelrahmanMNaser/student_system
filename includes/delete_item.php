<?php
include("db_connection.php");

function fetch_referenced($itemName)
{
  global $conn;
  $retrieve = "SELECT 
            TABLE_NAME,
            COLUMN_NAME, 
            REFERENCED_TABLE_NAME
          FROM 
            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
          WHERE 
            REFERENCED_TABLE_NAME = '$itemName'
  ";
  return $conn->query($retrieve);
}

function nullify_FK($result)
{
  global $conn;
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $table = $row["TABLE_NAME"];
      $column = $row["COLUMN_NAME"];
      $nullify_FK_query = "UPDATE '$table'  SET '$column' = NULL";
      $conn->query($nullify_FK_query);
    }
  }
}

function delete_FK($result)
{
  global $conn;
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $table = $row["TABLE_NAME"];
      $column = $row["COLUMN_NAME"];
      $delete_FK_query = "DELETE FROM '$table' WHERE '$column' IS NULL";
      $conn->query($delete_FK_query);
    }
  }
}

function delete_PK($itemName, $itemPK, $itemPKValue)
{
  global $conn;
  $delete_PK_query = "DELETE FROM $itemName WHERE $itemPK = '$itemPKValue'";
  $conn->query($delete_PK_query);
}

function delete_Row($itemName, $itemPK, $itemPKValue, $fullDelete = false)
{
  $result = fetch_referenced($itemName);

  if ($fullDelete) {
    delete_FK($result);
  } else {
    nullify_FK($result);
  }
  
  delete_PK($itemName, $itemPK, $itemPKValue);
}
