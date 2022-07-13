<?php

declare(strict_types=1);

namespace Post\App\Handlers;

use Post\App\Commands\ChangeTitlePost;
use Post\App\Commands\CreatePost;
use Post\Model\Post;
use Post\Model\PostCollection;
use Post\Model\Repository\PostRepository;

class ChangePostTitleHandler
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @param PostCollection $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(ChangeTitlePost $command) : void
    {
        // var_dump($this->postRepository->get($command->postId()));
        // die;
        $post = $this->postRepository->get($command->postId());
        $post->changeTitle($command->title());

        $this->postRepository->save($post);
    }
}
