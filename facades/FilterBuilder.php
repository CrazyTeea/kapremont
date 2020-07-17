<?php

namespace app\facades;

use Exception;

class FilterBuilder
{
    private $post;

    private $whereLikeClouse;

    private $whereClouse;

    public function __construct(object $post)
    {
        $this->post = $post;
    }

    public function where(string ...$params): object
    {
        foreach($params as $param) {
            try { $this->post->$param; } catch (Exception $e) {
                $this->whereClouse = "Unknown param $param";
                return $this;
            }
            $whereClouse[$param] = $this->post->$param;
        }
        $this->whereClouse = array_merge($this->whereClouse ?? [], $whereClouse);

        return $this;
    }

    public function whereLike(string ...$params): object
    {
        foreach ($params as $param) {
            try { $this->post->$param; } catch (Exception $e) {
                $this->whereLikeClouse = "Unknown param $param";
                return $this;
            }
            $postParam = $this->post->$param;
            $whereLikeClouse[] = "'like', '$param', '%$postParam%'";
        }
        $this->whereLikeClouse = array_merge($this->whereLikeClouse ?? [], $whereLikeClouse);

        return $this;
    }

    public function whereLikeLeft(string ...$params): object
    {
        foreach ($params as $param) {
            try { $this->post->$param; } catch (Exception $e) {
                $this->whereLikeClouse = "Unknown param $param";
                return $this;
            }
            $postParam = $this->post->$param;
            $whereLikeClouse[] = "'like', '$param', '%$postParam', false";
        }
        $this->whereLikeClouse = array_merge($this->whereLikeClouse ?? [], $whereLikeClouse);

        return $this;
    }

    public function whereLikeRight(string ...$params): object
    {
        foreach ($params as $param) {
            try { $this->post->$param; } catch (Exception $e) {
                $this->whereLikeClouse = "Unknown param $param";
                return $this;
            }
            $postParam = $this->post->$param;
            $whereLikeClouse[] = "'like', '$param', '$postParam%', false";
        }
        $this->whereLikeClouse = array_merge($this->whereLikeClouse ?? [], $whereLikeClouse);

        return $this;
    }

    public function get(): string
    {
        return implode(',', array_merge($this->whereClouse ?? [], $this->whereLikeClouse ?? []));
    }

    public function getAll(): array
    {
        return [
            'all' => array_merge($this->whereClouse ?? [], $this->whereLikeClouse ?? []),
            'where' => $this->whereClouse ?? [],
            'whereLike' => $this->whereLikeClouse ?? []
        ];
    }

    public function getWhere(): array
    {
        return $this->whereClouse ?? [];
    }

    public function getWhereLike(): array
    {
        return $this->whereLikeClouse ?? [];
    }
}
