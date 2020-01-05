<?php 
    class User extends Controller
    {
    
        public function index()
        {
            $this->view('account/login');
        }

        
        public function register()
        {
            $this->view('account/signup');
        }

        public function forgot()
        {
            $this->view('account/forget-password');
        }

        public function change()
        {
            $this->view('account/change-password');
        }

        public function new()
        {
            $this->view('account/new-password');
        }

    
    }
?>