<?php

namespace App\Interfaces;

interface SocialInterface
{


    public function index();

    public function getdata();

    public function show($id);

    public function create();

    public function store(array $data);

    public function delete($id);
}
