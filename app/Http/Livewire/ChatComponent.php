<?php

namespace App\Http\Livewire; ///home/nuser/code/qwen-chat/app/Http/Livewire/ChatComponent.php

use Livewire\Component;
use App\Services\QwenService;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ChatComponent extends Component
{
    use WithFileUploads;

    public $messages = [];
    public $contents = [];
    public $newMessage = null;
    public $responseMessage;
    public $limit = 3;
    public $request = 0;
    public $charLimit = 100;
    public $status = true;
    protected QwenService $qwenService;
    protected $usageStats,$conversationId;
    
    
    public $pdfFile;
    protected $rules = [
        'pdfFile' => 'required|file|mimes:pdf|max:2048', // Máximo 2MB
    ];
    public function updatedPdfFile()
    {
        $this->validate();
    }

    public function mount()
    {
        $this->messages[] = ['user' => 'qwen', 'text' => "Esta aplicación está conectada a un modelo de inteligencia artificial y responderá a tus consultas con la mayor precisión posible."];
        $this->contents = [
            ["role" => "system", "content" => 
            'Eres un asistente experto en auditoría de obras públicas en el marco jurídico de la República Bolivariana de Venezuela.'.
            'Usa todo tu conocimiento en procesos de auditoría, y tu base de datos estará centrada en las leyes, decretos y normativas oficiales del país.'.
            'En primera instancia, usa el contenido del documento PDF cargado (si existe). Si es necesario, complementa tus respuestas con información de otras fuentes oficiales disponibles públicamente, siempre respetando el marco legal del país.'.
            'En todo momento, cita las fuentes oficiales (como leyes, decretos o normativas) directamente en las respuestas.'.
            'Si se te solicita, incluye recomendaciones basadas en el análisis de la normativa, pero, si no es solicitado explícitamente, mantente en la información objetiva y literal de las fuentes.'.
            'La información debe ser clara, precisa y, cuando sea necesario, organizada en formatos que faciliten la lectura, como viñetas o encabezados.'.
            'Si la normativa está desactualizada o presenta ambigüedades, proporciona una advertencia o aclaración.'.
            'Da mayor relevancia a las leyes nacionales sobre resoluciones locales.'.
            'Responde de forma breve y concisa.'.            
            'Siempre responde enmarcado en este contexto, sí existe una pregunta fuera de el, siempre responderás que no tienes competencias para responder adecuadamente.'            
            ],
        ];
    }

    // Extraer el contenido de un PDF
    private function extractPdfContent($filePath)
    {
        $this->validate();
        // Usar una biblioteca para leer PDFs, como Smalot\PdfParser
        $parser = new \Smalot\PdfParser\Parser(); //dd($parser);
        $pdf = $parser->parseFile($filePath);
        return $pdf->getText();
    }

    public function sendMessage()
    {

        if (empty($this->newMessage) && !$this->pdfFile) {
            return;
        }

        $this->request++;

        if ($this->request <= $this->limit) {

            $this->status = true;

            if ($this->pdfFile) {

                // Almacenar temporalmente el archivo
                $filePath = $this->pdfFile->store('temp');

                // Leer el contenido del PDF
                $pdfContent = $this->extractPdfContent(storage_path('app/' . $filePath));

                // Agregar el contenido del PDF al historial
                $this->contents[] = ['role' => 'user', 'content' => "Contenido del PDF:\n$pdfContent"];

                // Eliminar el archivo temporal
                Storage::delete($filePath);

            } else {
                $this->contents[] = ['role' => 'user', 'content' => $this->newMessage];                
            }

            $this->contents[] = ["role" => "user", "content" => $this->newMessage];
            $qwenService = New QwenService;
            $response = $qwenService->sendMessage($this->contents); //dd($response);

            if (isset($response['error'])) {
                $this->responseMessage = "Ocurrió algo inesperado, lo síento...";
            } else {
                $response_text = $response['choices'][0]['message']['content'] ?? 'Respuesta no encontrada.'; //dd($this->responseMessage);
                $this->responseMessage = $this->formatToHtml($response_text); //dd($this->responseMessage);
                $this->usageStats = $response['usage'] ?? []; //dd($this->usageStats);
                $this->conversationId = $response['id'] ?? ''; //dd($this->conversationId);            
                $this->contents[] = ['role' => 'assistant', 'content' => $response_text]; //dd($this->contents);            
            }
            $this->messages[] = ['user' => 'user', 'text' => $this->newMessage];
            $this->messages[] = ['user' => 'qwen', 'text' => $this->responseMessage]; //dd($this->messages);
            $this->newMessage = null; //dd($this->newMessage);
            $this->status = ($this->request >= $this->limit) ? false : true;
            
        } else {
            $this->status = false;
        }        
    }

    public function render()
    {
        return view('livewire.chat-component');
    }


    function formatToHtml($text) {
        // Encabezados (### Título)
        $text = preg_replace('/### (.+)/', '<h3>$1</h3>', $text);
    
        // Negritas (**texto**)
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
    
        // Listas numeradas (1., 2., 3., etc.)
        $text = preg_replace_callback('/(\d+)\. (.+?)(?=\n\d+\. |\n-|$)/s', function ($matches) {
            $items = preg_split('/\n- /', $matches[2]);
            $listItems = '';
            foreach ($items as $item) {
                $listItems .= '<li>' . trim($item) . '</li>';
            }
            return '<ol start="' . $matches[1] . '">' . $listItems . '</ol>';
        }, $text);
    
        // Listas con guiones (- Item)
        $text = preg_replace_callback('/(?:^|\n)- (.+?)(?=\n(?:- |\d+\. )|$)/s', function ($matches) {
            $items = preg_split('/\n- /', $matches[0]);
            $listItems = '';
            foreach ($items as $item) {
                if (trim($item) !== '-') {
                    $listItems .= '<li>' . trim(ltrim($item, '- ')) . '</li>';
                }
            }
            return '<ul>' . $listItems . '</ul>';
        }, $text);
    
        // Párrafos (divide el texto por saltos de línea dobles)
        $text = preg_replace('/\n{2,}/', '</p><p>', $text);
        $text = '<p>' . $text . '</p>';
    
        return $text;
    }
    
}