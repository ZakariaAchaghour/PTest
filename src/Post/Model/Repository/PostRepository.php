<?php

namespace Post\Model\Repository;

use Post\Model\Post;
use Post\Model\ValueObjects\PostId;

interface PostRepository
{
    public function save(Post $post): void;

    public function get(PostId $postId): Post;

}