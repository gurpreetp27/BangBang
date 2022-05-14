<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class memberRegister extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
   public function rules()
    {
        return [
               
                'name' => 'required|string|min:4|max:255',
                'last_name' => 'required|string|min:4|max:255',
                'email' => 'required|email|unique:users,email,:id',
                'password' => 'required|string|min:6|confirmed',
                 ];
                 
    }

    public function response(array $errors)
    {
        if ($this->ajax())
        {
            return new JsonResponse(array('errors' => $errors));
        }
          else
            {

            return $this->redirector->to($this->getRedirectUrl())
                ->withInput($this->except($this->dontFlash))
                ->withErrors($errors, $this->errorBag);
            }
    }
}
