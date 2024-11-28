<?php  /// new in php 8.3 and php 8.4
// Dynamic constants
use App\Constants\UserRoles;
use App\Enum\PostStatus;

$roleName = 'ADMIN';
$roleValue = UserRoles::{$roleName}; // Dynamically accesses UserRoles::ADMIN

echo "Role Value: " . $roleValue; // Print “Role Value: admin”

?><br><br><?php

// Dynamic Enum members
$statusName = 'PUBLISHED';
$statusValue = PostStatus::{$statusName}->value; // Dynamically accesses PostStatus::Published
echo "Post Status: " . $statusValue; // Print “Post Status: published”

?><br><br><?php

//generate a select element with all status options
echo $this->Form->control('status', ['options' => PostStatus::list(), 'empty' => true]);

//print the text associated with the status value
echo h(PostStatus::list()['published']);

?>
<br><br>
<ol>
<li><a href="/posts/view/1">Example use finder to retrieve only appproved comments</a></li>
<li><a href="/posts">Example print status</a></li>
</ol>
