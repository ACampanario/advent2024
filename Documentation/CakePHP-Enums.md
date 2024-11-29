# Dynamic Enums (CakePHP 5 / PHP 8.3)

### 1.- We define a constant class of user roles

src/Constants/UserRoles.php

```
<?php
namespace App\Constants;

class UserRoles
{
    public const string ADMIN = 'admin';
    public const string EDITOR = 'editor';
    public const string VIEWER = 'viewer';
}
?>
```

### 2.- We define an Enum class for the status of the posts

src/Enum/PostStatus.php

```
<?php
namespace App\Enum;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public static function list(): array
    {
        return [
            self::DRAFT->value => __('DRAFT'),
            self::PUBLISHED->value => __('PUBLISHED'),
            self::ARCHIVED->value => __('ARCHIVED'),
        ];
    }
}
?>
```

### 3.- We define an Enum class for the status of the comments

src/Enum/CommentStatus.php

```
<?php
namespace App\Enum;

enum CommentStatus: string
{
    case APPROVED = 'approved';
    case DECLINED = 'declined';

    public static function list(): array
    {
        return [
            self::APPROVED->value => __('APPROVED'),
            self::DECLINED->value => __('DECLINED'),
        ];
    }
}
?>
```

### 4.- We check the dynamic use in the access to the Enums values.

templates/Pages/enums.php

```
<?php

/// new in php 8.3 and php 8.4

// Dynamic constants
use App\Constants\UserRoles;
use App\Enum\PostStatus;

$roleName = 'ADMIN';
$roleValue = UserRoles::{$roleName}; // Dynamically accesses UserRoles::ADMIN
echo "Role Value: " . $roleValue; // Print “Role Value: admin”

// Dynamic Enum members
$statusName = 'PUBLISHED';
$statusValue = PostStatus::{$statusName}->value; // Dynamically accesses PostStatus::Published
echo "Post Status: " . $statusValue; // Print “Post Status: published”

?>
```

### 5.- We can also use its functions, for example “list” for selectors and print its value.

```
<?php

//generate a select element with all status options
echo $this->Form->control('status', ['options' => PostStatus::list(), 'empty' => true]);

//print the text associated with the status value
echo h(PostStatus::list()['published']);	// Print “PUBLISHED”

?>
```

### 6.- They can be used dynamically in query operations, example to get a post and only your comments approved

src/Controller/PostsController.php

```
<?php
        $post = $this->Posts
            ->find('onlyCommentsByStatusEnum', status:  CommentStatus::APPROVED)
            ->contain(['Users'])
            ->where(['Posts.id' => $id])
            ->firstOrFail();
?>
```

src/Model/Table/PostsTable.php

```
<?php
    public function findOnlyCommentsByStatusEnum(SelectQuery $query, CommentStatus $status): SelectQuery
    {
        return $this->find()
            ->contain(['Comments' => function ($q) use ($status) {
                return $q->where([
                    'Comments.status' => $status->value,
                ]);
            }]);
    }
?>
```


