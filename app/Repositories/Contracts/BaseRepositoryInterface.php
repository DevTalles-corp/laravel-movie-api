<?php

interface BaseRepositoryInterface
{
    public function all(): Collection;
    public function findOrFail(int $id): Model;
    public function create(array $data):Model;
    public function update(Model $model, array $data):Model;
    public function delete(Model $model):void;
}