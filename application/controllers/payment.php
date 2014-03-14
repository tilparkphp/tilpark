<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function index()
	{
		$this->template->view('payment/dashboard');
	}
	
	
	public function add()
	{
		if(isset($_POST['add']) and is_log())
		{
			$continue = true;
			$this->form_validation->set_rules('account_id', get_lang('Account Card'), 'required|digits');
			$this->form_validation->set_rules('account_name', get_lang('Account Name'), 'required|min_length[3]|max_length[30]');
			$this->form_validation->set_rules('payment', get_lang('Payment'), 'required|number|max_length[12]');
		
			if ($this->form_validation->run() == FALSE)
			{
				$data['formError'] =  validation_errors();
			}
			else
			{
				$form['date'] = $this->input->post('date').' '.date('H:i:s');;
				$form['account_id'] = $this->input->post('account_id');
				$form['description'] = mb_strtoupper($this->input->post('description'), 'utf-8');
				$form['grand_total'] = $this->input->post('payment');
				$form['val_1'] = $this->input->post('payment_type');
				$form['val_2'] = $this->input->post('bank_name');
				$form['val_3'] = $this->input->post('branch_code');
				if($form['val_1'] == 'cheque'){$form['val_4'] = $this->input->post('fall_due_on');}
				if($form['val_1'] == 'cheque'){$form['val_5'] = $this->input->post('checks_serial_no');}
				$form['val_int'] = $this->input->post('cahsbox');
				
				
				$form['type'] = 'payment';
				if(isset($_GET['in'])){$form['in_out'] = 'in';} else if(isset($_GET['out'])){$form['in_out'] = 'out';}else{exit('93832485 error!');} 
				
				
				// hesap secenekleri
				$account = get_account($form['account_id']);
					$form['name'] 			= $account['name'];
					$form['name_surname'] 	= $account['name_surname'];
					$form['phone'] 			= $account['phone'];
					$form['gsm'] 			= $account['gsm'];
					$form['email'] 			= $account['email'];
					$form['address'] 		= $account['address'];
					$form['county'] 		= $account['county'];
					$form['city'] 			= $account['city'];
				
				# odeme hareketi ekle	
				$form_id = add_form($form);
				
				# kasayi tekrar hesapla
				calc_cahsbox($form['val_int']);
				
				if($form_id > 0)
				{
					calc_account_balance($form['account_id']);
					$data['type'] = 'invoice';
					$data['form_id'] = $form_id;
					$data['account_id'] = $form['account_id'];
					$data['title'] = get_lang('New Receipt');
					$data['description'] = 'Ödeme hareketi';
					add_log($data);
					
					$data['alert']['success'] = get_alertbox('alert-success', 'İşlemler başarılı', 'Kasa hareketi veritabanına eklendi.');	
				}
				else { alertbox('alert-danger', get_lang('Error!')); }
			}
		}
		
		$this->template->view('payment/add', @$data);	
	}
	
	public function lists()
	{
		$data['meta_title'] = 'Kasa & Banka Hareketleri';
		$this->db->where('status', 1);
		$this->db->where('type', 'payment');
		$this->db->order_by('ID', 'DESC');
		$data['payments'] = $this->db->get('forms')->result_array();
	
		$this->template->view('payment/lists', $data);	
	}
	
	public function view($payment_id)
	{
		$data['invoice_id'] = $payment_id;
		$this->template->view('payment/payment_view',$data);	
	}
	
	
	public function cashbox($cashbox='')
	{
		$cashbox = get_option(array('id'=>$cashbox, 'group'=>'cashbox'));
		if($cashbox)
		{
			$data['cashbox'] = $cashbox;
			
			$data['meta_title'] = $cashbox['key'].' Detayları';
			$this->db->where('status', 1);
			$this->db->where('type', 'payment');
			$this->db->where('val_int', $cashbox['id']);
			$this->db->order_by('ID', 'ASC');
			$data['payments'] = $this->db->get('forms')->result_array();
			
			$this->template->view('payment/cashbox_detail', @$data);
			return false;	
		}
		
		if(isset($_POST['add']))
		{
			$cash['name'] = $this->input->post('name');	
			
			$option['group'] 		= 'cashbox';
			$option['key'] 			= $cash['name'];
			$option['group'] 		= $this->input->post('type');	
			$option['val_2'] 		= $this->input->post('branch_code');
			$option['val_3'] 		= $this->input->post('account_no');
			$option['val_4'] 		= $this->input->post('iban');
			$option['val_5']	= '';
			update_option($option);
			
			// log
			$log['type'] = 'cashbox';
			$log['title'] = 'Yeni Kasa';
			$log['description'] = 'Yeni kasa oluşturdu. ['.$option['key'].']';
			add_log($log);
		}
		
		if(isset($_GET['set']))
		{
			$cashbox_id = $this->input->get('cashbox_id');	
			
			$cashbox = get_option(array('id'=>$cashbox_id, 'group'=>'cashbox'));
			
			if($cashbox)
			{
				/* varsayilan kasa
					varsayilan kasayi degistirmek icin */
				if(isset($_GET['default']))
				{
					$this->db->where('group', 'cashbox');
					$this->db->where('val_1', 'default');
					$this->db->update('options', array('val_1'=>''));
					
					if(update_option(array('id'=>$cashbox_id, 'group'=>'cashbox', 'val_1'=>'default')))
					{
						$data['success']['change_default_cashbox'] = get_alertbox('alert-success','Varsayılan kasa değişti.', $cashbox['key'].' varsayılan kasa olarak güncellendi.');
					}
				}
				
				/* kasa silmek
					kasa silmek icin */
				if(isset($_GET['delete']))
				{	
					if($cashbox['val_1'] == 'default')
					{
						$data['alerts']['default_cashbox_no_delete'] = get_alertbox('alert-warning','Varsayılan kasa silinemez.', $cashbox['key'].' varsayılan kasa olarak atanmış. Bu kasayı silemezsin.');
					}
					else if($cashbox['val_decimal'] > 0)
					{
						$data['alerts']['default_cashbox_no_delete'] = get_alertbox('alert-warning','Bu kasada para var!', $cashbox['key'].' kasasında '.get_money($cashbox['val_decimal']).' tutarında nakit bulunmakta. Lütfen kasayı boşaltın.');
					}
					else
					{
						if(update_option(array('id'=>$cashbox['id'], 'val_5'=>'delete')))
						{
							$data['success']['change_default_cashbox'] = get_alertbox('alert-danger','Kasa silindi.', $cashbox['key'].' kasası silindi.');
						}	
					}
				}
			}
		}
		
		$this->template->view('payment/cashbox', @$data);	
	}
	
	
	public function search_account($text='')
	{
		$this->db->where('status', '1');
		$this->db->like('code', urldecode($text));
		$this->db->or_like('name', urldecode($text));
		$this->db->or_like('gsm', urldecode($text));
		$this->db->limit(7);
		$query = $this->db->get('accounts')->result_array();
		$data['accounts'] = $query;
		
		$this->load->view('payment/typehead_search_account', $data);
	}
	
	
}
