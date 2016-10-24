<?php namespace EscojLB\Repo\Judgment;

interface JudgmentInterface {

	/**
     * Create a new Judgment
     *
     * @param array  Data to create a new user object
     * @return User Object
     */
    public function create(array $data);

    /**
     * Get all judgments as key-value array 
     *
     * @param   
     * @return array    Associative Array with all the judgements ordered by date
     */
    public function findAll();

}
