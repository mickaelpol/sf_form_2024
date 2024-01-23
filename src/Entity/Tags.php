<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
class Tags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * Many Tags have Many Posts.
     */
    #[ManyToMany(targetEntity: Posts::class, mappedBy: 'fk_tags')]
    private Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Posts $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->addFkTag($this);
        }

        return $this;
    }

    public function removePost(Posts $post): static
    {
        if ($this->posts->removeElement($post)) {
            $post->removeFkTag($this);
        }

        return $this;
    }
}
