<?php

declare(strict_types=1);

namespace Post\App\Handlers;

use Post\App\Commands\CreatePost;
use Post\Model\Post;
use Post\Model\PostCollection;
use Post\Model\Repository\PostRepository;
use Prooph\ServiceBus\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateHandler
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

    public function __invoke(CreatePost $command) : void
    {
        // var_dump($command);
        // die;
        $post = Post::create($command->postId(), $command->title(), $command->content());

        $this->postRepository->save($post);
    }
}
