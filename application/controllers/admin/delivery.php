<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery extends Admin {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		//FILTRY
		if(!$this->session->userdata('deliveries_start') || !$this->session->userdata('deliveries_end')) {
			
			$this->session->set_userdata(array('deliveries_start' => date("Y-m-d")));
			$this->session->set_userdata(array('deliveries_end' => date("Y-m-d", strtotime("+2days"))));

		}
		
		if($this->input->post('save') == 1 || $this->input->post('reset') == 1) {
			
			if($this->input->post('reset') == 1) {
				$this->session->set_userdata(array('deliveries_start' => date("Y-m-d")));
				$this->session->set_userdata(array('deliveries_end' => date("Y-m-d", strtotime("+2days"))));
			} else {
				
				$t = explode(" do ", $this->input->post('deliveries_range'));
				
				$this->session->set_userdata(array('deliveries_start' => $t[0]));
				$this->session->set_userdata(array('deliveries_end' => $t[1]));
			}
			
		}
		
		
		$date_start = $this->session->userdata('deliveries_start');
		$date_end = $this->session->userdata('deliveries_end');
		$days_forward = ((strtotime($date_end)-strtotime($date_start))/(3600*24))+1;

		$this->data['date_start'] = $date_start;
		$this->data['date_end'] = $date_end;
		$this->data['days_forward'] = $days_forward;
		
		$this->data['all_users'] = $this->delivery->get_deliveries_users_for_admin_calendar($date_start, $date_end);
		$this->data['all_deliveries'] = $this->delivery->get_deliveries_for_admin_calendar($date_start, $date_end);
		$this->data['all_deliveries_selected_meals'] = $this->delivery->get_deliveries_selected_meals_for_admin_calendar($this->data['all_deliveries']);
	
		$this->data['template'] = $this->load->view('admin/delivery/delivery', $this->data, true);
		$this->load->view('cp/index', $this->data);
		
	}
	
	function get() {
	
		if($this->input->post('download') == 1) {
			
			$date = $this->input->post('date');
			$extension = $this->input->post('extension');
			$data = $this->input->post('data');
			
			if($extension == 'pdf') {
				
				$this->get_pdf($date, $data, true);
				
			} else {
				
				$this->get_xls($date, $data, true);
				
			}
			
		}
	
	}
	
	
	function get_pdf($date, $data = FALSE, $post = FALSE) {
		
		if($data == FALSE && $post == FALSE) {
			$data = array('grammage' => 1);
		}
		
		$date = date("Y-m-d", strtotime($date));		
		$all_deliveries = $this->delivery->get_deliveries_for_admin_calendar($date, $date);
		
		$this->data['date'] = $date;
		$this->data['data'] = $data;
		$this->data['all_users'] = $this->delivery->get_deliveries_users_for_admin_calendar($date, $date);
		$this->data['all_deliveries'] = $all_deliveries[$date];

		$this->load->helper('dompdf');
	
		$html = $this->load->view('admin/delivery/pdf', $this->data, true);
		pdf_create($html, 'dostawy_' . $date, TRUE, 0);
		

	}
	
	function get_xls($date, $data = FALSE, $post = FALSE) {
		
		if($data == FALSE && $post == FALSE) {
			$data = array('grammage' => 1);
		}
		
		$date = date("Y-m-d", strtotime($date));
		
		$all_deliveries = $this->delivery->get_deliveries_for_admin_calendar($date, $date);
		$all_deliveries = $all_deliveries[$date];
		$all_users = $this->delivery->get_deliveries_users_for_admin_calendar($date, $date);

		/*
		if($data['grammage'] == 1 && !$data['delivery']) {
			$letter = "N";
		} elseif(!$data['grammage'] && $data['delivery'] == 1) {
			$letter = "P";
		} elseif($data['grammage'] == 1 && $data['delivery'] == 1) {
			$letter = "P";
		} else {
			$letter = "C";
		}
		/**/
				
		$letter = "R";

		$this->load->library('phpexcel/Classes/PHPExcel');
		
		$sheet = $this->phpexcel->getActiveSheet();	
		$sheet->getRowDimension(1)->setRowHeight(20);
		$sheet->getRowDimension(2)->setRowHeight(20);
		$sheet->getRowDimension(3)->setRowHeight(20);
		$sheet->getStyle('A1:'.$letter.'3')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'bfd453')
				),
				'alignment' => array(
					'wrap'       => true,
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 12
				)
			)
		);
		$sheet->getStyle('D3:M3')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '442a19')
				),
				
			)
		);
		$sheet->getStyle('A1:'.$letter.'1')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '442a19')
				),
				
			)
		);
		$sheet->getStyle('A1:P999')->getAlignment()->setWrapText(true);
		
		$sheet->mergeCells('A1:'.$letter.'1');
		$sheet->setCellValue('A1', 'posiłki w dniu ' . strftime("%Y-%m-%d, %A", strtotime($date)));
		
		$sheet->mergeCells('A2:A3');
		$sheet->setCellValue('A2', 'Imię i nazwisko');
		$sheet->mergeCells('B2:B3');
		$sheet->setCellValue('B2', 'Telefon');
		$sheet->mergeCells('C2:C3');
		$sheet->setCellValue('C2', 'Nr dostawy');
		
		if($data['grammage'] == 1) {
		
			$sheet->mergeCells('D2:E2');
			$sheet->setCellValue('D2', 'Posiłek 1');
			$sheet->setCellValue('D3', 'W');
			$sheet->setCellValue('E3', 'B');
			$sheet->mergeCells('F2:G2');
			$sheet->setCellValue('F2', 'Posiłek 2');
			$sheet->setCellValue('F3', 'W');
			$sheet->setCellValue('G3', 'B');
			$sheet->mergeCells('H2:I2');
			$sheet->setCellValue('H2', 'Posiłek 3');
			$sheet->setCellValue('H3', 'W');
			$sheet->setCellValue('I3', 'B');
			$sheet->mergeCells('J2:K2');
			$sheet->setCellValue('J2', 'Posiłek 4');
			$sheet->setCellValue('J3', 'W');
			$sheet->setCellValue('K3', 'B');
			$sheet->mergeCells('L2:M2');
			$sheet->setCellValue('L2', 'Posiłek 5');
			$sheet->setCellValue('L3', 'W');
			$sheet->setCellValue('M3', 'B');
		}
		
		if($data['notice'] == 1) {
			$sheet->mergeCells('N2:N3');
			$sheet->setCellValue('N2', 'Uwagi klienta');
		}
		
		if($data['grammage'] == 1) {
			$sheet->mergeCells('O2:O3');
			$sheet->setCellValue('O2', 'Uwagi');
		}
		
		if($data['delivery'] == 1) {
		
			$sheet->mergeCells('P2:P3');
			$sheet->setCellValue('P2', 'Adres dostawy');
			
			$sheet->mergeCells('Q2:Q3');
			$sheet->setCellValue('Q2', 'Uwagi');
		
		}
		
		if($data['price'] == 1) {
			$sheet->mergeCells('R2:R3');
			$sheet->setCellValue('R2', 'Cena');
		}
		
		//for
		$start_row = 4;
		foreach($all_users as $i => $u) {
			
			
			$sheet->getRowDimension($start_row)->setRowHeight(-1);
			$sheet->getRowDimension($start_row+1)->setRowHeight(-1);
			
			$sheet->setCellValue('A' . $start_row, $u->name_surname);
			$sheet->getColumnDimension('A')->setWidth(15);
			
			$sheet->setCellValue('B' . $start_row, $u->phone);
			$sheet->getColumnDimension('B')->setWidth(11);
			
			$sheet->setCellValue('C' . $start_row,  $all_deliveries[$u->user_id][0]->number);
			$sheet->getColumnDimension('C')->setWidth(13);
			
			if($data['grammage'] == 1) {
			
				//POSIŁEK 1
				$sheet->getColumnDimension('D')->setWidth(6);
				$sheet->getColumnDimension('E')->setWidth(6);
				if($all_deliveries[$u->user_id][0]->meal_1) {
					$sheet->mergeCells('D' . $start_row . ':E' . $start_row );	
					$sheet->setCellValue('D' . $start_row,  $all_deliveries[$u->user_id][0]->meal_1);
					$sheet->setCellValue('D' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_1_w);
					$sheet->setCellValue('E' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_1_b);
				} else {
					$sheet->mergeCells('D' . $start_row . ':D' . ($start_row + 1));	
					$sheet->mergeCells('E' . $start_row . ':E' . ($start_row + 1));
					$sheet->setCellValue('D' . $start_row,  $all_deliveries[$u->user_id][0]->meal_1_w);
					$sheet->setCellValue('E' . $start_row,  $all_deliveries[$u->user_id][0]->meal_1_b);
				}
				
				
				
				//POSIŁEK 2
				$sheet->getColumnDimension('F')->setWidth(6);
				$sheet->getColumnDimension('G')->setWidth(6);
				if($all_deliveries[$u->user_id][0]->meal_2) {
					$sheet->mergeCells('F' . $start_row . ':G' . $start_row );	
					$sheet->setCellValue('F' . $start_row,  $all_deliveries[$u->user_id][0]->meal_2);
					$sheet->setCellValue('F' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_2_w);
					$sheet->setCellValue('G' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_2_b);
				} else {
					$sheet->mergeCells('F' . $start_row . ':F' . ($start_row + 1));	
					$sheet->mergeCells('G' . $start_row . ':G' . ($start_row + 1));
					$sheet->setCellValue('F' . $start_row,  $all_deliveries[$u->user_id][0]->meal_2_w);
					$sheet->setCellValue('G' . $start_row,  $all_deliveries[$u->user_id][0]->meal_2_b);
				}
	
				
				//POSIŁEK 3
				$sheet->getColumnDimension('H')->setWidth(6);
				$sheet->getColumnDimension('I')->setWidth(6);
				if($all_deliveries[$u->user_id][0]->meal_3) {
					$sheet->mergeCells('H' . $start_row . ':I' . $start_row );	
					$sheet->setCellValue('H' . $start_row,  $all_deliveries[$u->user_id][0]->meal_3);
					$sheet->setCellValue('H' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_3_w);
					$sheet->setCellValue('I' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_3_b);
				} else {
					$sheet->mergeCells('H' . $start_row . ':H' . ($start_row + 1));	
					$sheet->mergeCells('I' . $start_row . ':I' . ($start_row + 1));
					$sheet->setCellValue('H' . $start_row,  $all_deliveries[$u->user_id][0]->meal_3_w);
					$sheet->setCellValue('I' . $start_row,  $all_deliveries[$u->user_id][0]->meal_3_b);
				}
				
				//POSIŁEK 4
				$sheet->getColumnDimension('J')->setWidth(6);
				$sheet->getColumnDimension('K')->setWidth(6);
				if($all_deliveries[$u->user_id][0]->meal_4) {
					$sheet->mergeCells('J' . $start_row . ':K' . $start_row );	
					$sheet->setCellValue('J' . $start_row,  $all_deliveries[$u->user_id][0]->meal_4);
					$sheet->setCellValue('J' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_4_w);
					$sheet->setCellValue('K' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_4_b);
				} else {
					$sheet->mergeCells('J' . $start_row . ':J' . ($start_row + 1));	
					$sheet->mergeCells('K' . $start_row . ':K' . ($start_row + 1));
					$sheet->setCellValue('J' . $start_row,  $all_deliveries[$u->user_id][0]->meal_4_w);
					$sheet->setCellValue('K' . $start_row,  $all_deliveries[$u->user_id][0]->meal_4_b);
				}
				
				//POSIŁEK 5
				$sheet->getColumnDimension('L')->setWidth(6);
				$sheet->getColumnDimension('M')->setWidth(6);
				if($all_deliveries[$u->user_id][0]->meal_5) {
					$sheet->mergeCells('L' . $start_row . ':M' . $start_row );	
					$sheet->setCellValue('L' . $start_row,  $all_deliveries[$u->user_id][0]->meal_5);
					$sheet->setCellValue('L' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_5_w);
					$sheet->setCellValue('M' . ($start_row+1),  $all_deliveries[$u->user_id][0]->meal_5_b);
				} else {
					$sheet->mergeCells('L' . $start_row . ':L' . ($start_row + 1));	
					$sheet->mergeCells('M' . $start_row . ':M' . ($start_row + 1));
					$sheet->setCellValue('L' . $start_row,  $all_deliveries[$u->user_id][0]->meal_5_w);
					$sheet->setCellValue('M' . $start_row,  $all_deliveries[$u->user_id][0]->meal_5_b);
				}
			}
			
			if($data['notice'] == 1) {
				//UWAGI KLIENTA
				$sheet->setCellValue('N' . ($start_row + 1),  $all_deliveries[$u->user_id][0]->user_notice);
				$sheet->getColumnDimension('N')->setWidth(20);
			}
			
			if($data['grammage'] == 1) {
				//UWAGI
				$sheet->setCellValue('O' . ($start_row + 1),  $all_deliveries[$u->user_id][0]->keyword . " \n" . $all_deliveries[$u->user_id][0]->notice);
				$sheet->getColumnDimension('O')->setWidth(20);
			
			}
			
			if($data['delivery'] == 1) {
			
				//ADRES
				$sheet->setCellValue('P' . ($start_row + 1),  $all_deliveries[$u->user_id][0]->name_surname . " \n" . $all_deliveries[$u->user_id][0]->address. " \n" . $all_deliveries[$u->user_id][0]->postcode. " " . $all_deliveries[$u->user_id][0]->city . "" . (($all_deliveries[$u->user_id][0]->hours)?"\n" . reset(delivery_hours_values($all_deliveries[$u->user_id][0]->hours)):''));
				$sheet->getColumnDimension('P')->setWidth(20);
				
				//UWAGI
				$sheet->setCellValue('Q' . ($start_row + 1),  $all_deliveries[$u->user_id][0]->delivery_notice);
				$sheet->getColumnDimension('Q')->setWidth(20);

			}

			if($data['price'] == 1) {
				//CENA
				$sheet->setCellValue('R' . ($start_row + 1),  $all_deliveries[$u->user_id][0]->price);
				$sheet->getColumnDimension('R')->setWidth(20);
			}
			
			if($start_row%4) {
				$sheet->getStyle('A'.$start_row.':'.$letter.''.($start_row+1))->applyFromArray(
					array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'f2f2f2')
						),
						
					)
				);
			}
			/**/
			
			$start_row += 2;
		}
		
		$borders = array(
			   'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '482e1f'),
					 ),
			   ),
			   'alignment' => array(
					'wrap'       => true,
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
		); 

		$sheet->getStyle('D2:E' . ($start_row-1))->applyFromArray($borders);
		$sheet->getStyle('F2:G' . ($start_row-1))->applyFromArray($borders);
		$sheet->getStyle('H2:I' . ($start_row-1))->applyFromArray($borders);
		$sheet->getStyle('J2:K' . ($start_row-1))->applyFromArray($borders);
		$sheet->getStyle('L2:M' . ($start_row-1))->applyFromArray($borders);
		
		//CLEANING
		$sheet->getColumnDimension('C')->setVisible(false);
		if(!$data['notice']) {
			$sheet->getColumnDimension('N')->setVisible(false);
		}
		if(!$data['grammage']) {
			for ($col = 'D'; $col <= 'M'; $col++) {
				$sheet->getColumnDimension($col)->setVisible(false);
			}
			$sheet->getColumnDimension('O')->setVisible(false);
		}
		if(!$data['delivery']) {
			$sheet->getColumnDimension('P')->setVisible(false);
			$sheet->getColumnDimension('Q')->setVisible(false);
		}
		if(!$data['price']) {
			$sheet->getColumnDimension('R')->setVisible(false);
		}
		
		$writer = new PHPExcel_Writer_Excel5($this->phpexcel); 
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="fit4you_posilki_'.$date.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$writer->save('php://output'); 
		
	}
	
	
	function get_statistics() {
		
		$date_start = $this->session->userdata('deliveries_start');
		$date_end = $this->session->userdata('deliveries_end');
		$days_forward = ((strtotime($date_end)-strtotime($date_start))/(3600*24))+1;

		$this->data['date_start'] = $date_start;
		$this->data['date_end'] = $date_end;
		$this->data['days_forward'] = $days_forward;
		
		$this->data['all_users'] = $all_users = $this->delivery->get_deliveries_users_for_admin_calendar($date_start, $date_end);
		$this->data['all_deliveries'] = $all_deliveries = $this->delivery->get_deliveries_for_admin_calendar($date_start, $date_end);
		$all_deliveries_selected_meals = $this->delivery->get_deliveries_selected_meals_for_admin_calendar($all_deliveries);

		//LICZE
		if(!empty($all_deliveries)) {
			foreach($all_deliveries as $date => $user) {
				
				$stat[$date][1] = 0;
				$stat[$date][2] = 0;
				$stat[$date][3] = 0;
				$stat[$date][4] = 0;
				$stat[$date][5] = 0;
				
				foreach($user as $user_id => $v) {
					for($i=1;$i<=5;$i++) {
						if(in_array($i, unserialize($all_deliveries_selected_meals[$v[0]->order_id]->meals_selected))) {
							$stat[$date][$i]++;
						}
					}
				}
			}
		}
		
		$this->data['stat'] = $stat;
		
		//printr($stat);
		//printr();
		//printr($all_deliveries);
		
		$this->load->helper('dompdf');
	
		$html = $this->load->view('admin/delivery/statistic', $this->data, true);
		pdf_create($html, 'statystyki_' . $date_start . '_' . $date_end, TRUE, 0);
		

	}
	
	
	
	public function calendar($date, $user_id = FALSE) {
		
		//$this->firephp->log($date);
		
		$datetime = strtotime($date);
		$date = date("Y-m-d", $datetime);
		
		if(!$user_id) {
			$user_id = $this->user->user_id;	
		}
		
		$prefs = array (
						'start_day'    => 'monday',
						'month_type'   => 'long',
						'day_type'     => 'short'
						);				 			
					 	 
		$prefs['template'] = '	
		   {table_open}<table class="table table-condensed table-bordered delivery_calendar text-center margin_b_0">{/table_open}
		
			   {heading_row_start}<tr>{/heading_row_start}
			
			   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
			   {heading_title_cell}<th colspan="{colspan}" class="bg_success text-center">{heading}</th>{/heading_title_cell}
			   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
			
			   {heading_row_end}</tr>{/heading_row_end}
			
			   {week_row_start}<tr>{/week_row_start}
			   {week_day_cell}<td class="bg_line" style="width: '.(100/7).'%">{week_day}</td>{/week_day_cell}
			   {week_row_end}</tr>{/week_row_end}
			
			   {cal_row_start}<tr>{/cal_row_start}
			   {cal_cell_start}<td>{/cal_cell_start}
			
			   {cal_cell_content}<span class="muted disabled tooltipa" title="W ten dzień już jest dostawa!">{day}</span>{/cal_cell_content}
			   {cal_cell_content_today}<div class="muted disabled tooltipa" title="W ten dzień już jest dostawa!">{day}</div>{/cal_cell_content_today}
			
			   {cal_cell_no_content}<span class="free pointer" data-date="{year}-{month}-{day}" id="delivery_calendar_day_{year}-{month}-{day}">{day}</span>{/cal_cell_no_content}
			   {cal_cell_no_content_today}<div class="today pointer"><span class="free" data-date="{year}-{month}-{day}" id="delivery_calendar_day_{year}-{month}-{day}">{day}</span></div>{/cal_cell_no_content_today}
			
			   {cal_cell_blank}&nbsp;{/cal_cell_blank}
			
			   {cal_cell_end}</td>{/cal_cell_end}
			   {cal_row_end}</tr>{/cal_row_end}
			
		   {table_close}</table>{/table_close}
		';
		$this->load->library('calendar', $prefs);

		//calendarsy
		$data = $this->delivery->get_deliveries_for_user_calendar($user_id);
		
		$calendar = $this->calendar->generate(date("Y", strtotime($date)), date("n", strtotime($date)), $data[date("Y", strtotime($date))][date("n", strtotime($date))]);
		
		echo $calendar;
		
	}
	
	
	
}