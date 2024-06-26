<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

use Storage;
use PDF;

use DB;



class InvoiceController extends Controller
{
    public function createNewInvoice() {
        $rec = Client::orderBy('id', 'desc')->get();
        $date = date('F, Y');
        $title = "Invoices of Clients for Month ".$date;
        $data = compact('rec','title');
        return view('invoices.unpaid-invoices',$data);
    }

    public function createNewInvoiceTable($id) {

        $client = Client::find($id);
        if($client) {
            $id = $client->id;
            $route = "/confirm-invoice/".$client->id;
            $title = "Invoice for  ".$client->client_name;
            $btn_text = "Proceed";
            return view('invoices.create-new-invoice',compact('id','title','client','btn_text','route'));
        } else {
            return back();
        }
    }
    public function previewInvoice($id, Request $req) {
        $req->validate([
            'invoice_month' => 'required',
            'invoice_description' => 'required',
            'invoice_amount' => 'required',
            'invoice_due_date' => 'required',
            'invoice_method' => 'required'
        ]);
        $client = Client::find($id);
        if($client) {
            $id = $client->id;
            // data
            $invoice_month = $req->invoice_month;
            $invoice_description = $req->invoice_description;
            $invoice_profit = $req->invoice_profit;
            $invoice_amount = $req->invoice_amount;
            $invoice_due_date = $req->invoice_due_date;
            $invoice_method = $req->invoice_method;
            $invoice_notes = $req->invoice_notes;

            $route = "/send-invoice/".$client->id;
            $title = "Invoice for  ".$client->client_name;
            $btn_text = "Send Invoice";
            return view('invoices.confirm-invoice',compact('invoice_notes','invoice_method','invoice_due_date','invoice_amount','invoice_profit','invoice_description','invoice_month','id','title','client','btn_text','route'));
        } else {
            return view('index.index');
        }
    }

    public function sendInvoice($id, Request $req) {
        $client_name = $req->client_name_hidden;
        $client_email = $req->client_email_hidden;
        $client_phone = $req->client_phone_hidden;
        $invoice_date = date('d.m.Y');
        $invoice_month =$req->invoice_month_hidden;
        $invoice_description =$req->invoice_description;
        $invoice_profit =$req->invoice_profit_hidden;
        $invoice_amount =$req->invoice_amount_hidden;
        $invoice_due_date =$req->invoice_due_date_hidden;
        $invoice_method =$req->invoice_method_hidden;
        $invoice_notes =$req->invoice_notes_hidden;
        $client_id =$req->client_id;

        // Generate absolute path for the image file
        $logo_path = public_path('reblat-logo.png');
        // dd($req->invoice_method_hidden);
        $invoice_number = Str::random(8); // Adjust the length as needed
        $data = compact('logo_path','invoice_notes','invoice_method','invoice_due_date','invoice_amount','invoice_description','invoice_profit','invoice_month','invoice_date','invoice_number','client_phone','client_name','client_email');
        // return view('invoices.preview-invoice',$data);
        $pdf_name = 'invoices/'.$client_name."_".date('m_Y').".pdf";
        $pdf = PDF::loadView('invoices.preview-invoice',$data)->setOptions(['defaultFont' => 'sans-serif']);
        // dd('done');
        $pdfPath = $pdf->save(public_path($pdf_name));
        // dd("sent");
        $mail_subject = "Invoice for Month of ".$invoice_month;
        $pdfContent = $pdf->output();
        Mail::send('invoices.email-template', $data, function ($message) use ($mail_subject, $client_email, $pdfContent) {
            $message->to($client_email)
                    ->subject($mail_subject)
                    // ->bcc('reblatesols.com+0797e8c7fc@invite.trustpilot.com')
                    ->attachData($pdfContent, 'invoice.pdf', [
                        'mime' => 'application/pdf',
                    ]);
        });



        $invoice = new Invoice();
        $invoice->invoice_id = $invoice_number;
        $invoice->client_name = $client_name;
        $invoice->status = "done";
        $invoice->period = $invoice_month;
        $invoice->description = $invoice_description;
        $invoice->due_date = $invoice_due_date;
        $invoice->payment_method = $invoice_method;
        $invoice->profit = $invoice_profit;
        $invoice->additional_notes = $invoice_notes;

        $invoice->pdf_path = $pdf_name;
        $invoice->date = date('Y-m-d');
        $invoice->client_id  = $client_id;
        $invoice->amount = $invoice_amount;
        $invoice->save();


        $message = "Invoice has been sent to ".$client_name;


        return redirect('/create-new-invoice')->with('email_sent',$message);


    }
    public function viewInvoices() {
        $rec = DB::table('clients')->orderBy('id','desc')->get();
        // dd($rec);
        if($rec) {
            $title = "Invoices Of Registered Clients";
            $data = compact('rec','title');
            return view('invoices.view-invoices',$data);
        }
        else {
            return redirect('/');
        }

    }

    public function viewIndividualInvoices($id) {
        // dd($id);
        $emp = Invoice::where('client_id', $id)->orderBy('id','desc')->get();
        $client = DB::table('clients')->where('client_id',$id)->first();
        // dd($emp);
        if($emp) {
                $title = "Invoices of ".$client->client_name;
                $data = compact('title','emp');
                return view('invoices.individual-invoice',$data);
            } else {
                return redirect('/view-invoices')->with('not_found','No record found!');
            }
    }

    // view invoice on browser
    public function previewOnBrowser($id) {
        $in = DB::table('invoices')->where('id',$id)->first();
        $client = DB::table('clients')->where('client_id',$in->client_id)->first();

        $invoice_number = $in->invoice_id;
        $client_name = $client->client_name;
        $client_phone = $client->client_phone;
        $client_email = $client->client_email;
        $invoice_month = $in->period;
        $invoice_description = $in->description;
        $invoice_profit = $in->profit;
        $invoice_amount = $in->amount;
        $invoice_notes = $in->additional_notes;

        $data = compact(
            'invoice_number',
            'client_name',
            'client_phone',
            'client_email',
            'invoice_month',
            'invoice_description',
            'invoice_profit',
            'invoice_amount',
            'invoice_notes'
        );

        return view('invoices.browser-invoice',$data);

        // $pdf = PDF::loadView('invoices.browser-invoice.blade')->setOptions(['defaultFont' => 'sans-serif']);
        // dd($data);
    }

}
