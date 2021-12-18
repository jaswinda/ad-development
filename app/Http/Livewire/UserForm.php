<?php

namespace App\Http\Livewire;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class UserForm extends Component
{
    protected $listeners = [
        'update-document' => 'updateDocument',
    ];
    use WithFileUploads;
    public $full_name;
    public $father_name;
    public $date_of_birth;
    public $document_type='1';
    public $document_number;
    public $document_issue_place;
    public $document_issue_date;
    public $uploaded_document;


    protected function rules()
    {
        return [
            'full_name' => 'required|min:6',
            'father_name' => 'required|min:6',
            'date_of_birth' => 'required|date',
            'document_type' => 'required|min:1',
            'document_number' => 'required|min:6',
            'document_issue_place' => 'required|min:6',
            'document_issue_date' => 'required|date',
            // 'document_image' =>  'image|mimes:jpeg,png,jpg',
        ];
    }
    public function render()
    {

        $this->uploaded_document = Document::where('user_id', Auth::id())->first();

        return view('livewire.user-form');

    }
    public function submit(Request $request)
    {
        $this->validate();
        $document=new Document();
        $document->full_name=$this->full_name;
        $document->father_name=$this->father_name;
        $document->date_of_birth=$this->date_of_birth;
        $document->document_type=$this->document_type;
        $document->document_number=$this->document_number;
        $document->document_issue_place=$this->document_issue_place;
        $document->document_issue_date=$this->document_issue_date;
        $document->document_image='/images/no-image.png';
        $document->user_id=Auth::user()->id;
        $document->save();
    }
    public function updateDocument($image)
    {
        if($image!=null)
        {
            $document = Document::where('user_id', Auth::id())->first();
            $document->document_image = $image;
            $document->save();
        }

    }

}
