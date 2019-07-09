<?php
	
	class Ravis_booking_db_class
	{
		
		public function required_tables()
		{
			global $wpdb;
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$charset_collate = $wpdb->get_charset_collate();
			
			/**
			 * Create Booking Room table
			 * @var string table_name
			 */
			$sql1 = "CREATE TABLE " . ( $wpdb->prefix . 'ravis_booking' ) . " (
				id int NOT NULL AUTO_INCREMENT,
				f_name VARCHAR(255) NOT NULL,
				l_name VARCHAR(255) NOT NULL,
				phone VARCHAR(100) NOT NULL,
				email VARCHAR(255) NOT NULL,
				address text NOT NULL,
				requirements text NOT NULL,
				rooms text NOT NULL,
				check_in date NOT NULL,
				check_out date NOT NULL,
				status tinyint NOT NULL DEFAULT '1',
				confirmed tinyint NOT NULL DEFAULT '0',
				booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				comment text,
				payment_method tinyint NOT NULL,
				total_price DECIMAL(15,5) NOT NULL,
				vat DECIMAL(15,5) NOT NULL,
				duration int NOT NULL,
				weekends int NOT NULL,
				invoice_id int NOT NULL,
				booking_info text NOT NULL,
				user_id int NOT NULL,
				payment_status tinyint NOT NULL DEFAULT '0',
				booking_currency text NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $sql1 );
			
			/**
			 * Create Invoice table
			 * @var string table_name
			 */
			$sql4 = "CREATE TABLE " . ( $wpdb->prefix . 'ravis_invoice' ) . " (
				id int NOT NULL AUTO_INCREMENT,
				booking_id int NOT NULL,
				booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				price DECIMAL(15,5) NOT NULL,
				status tinyint NOT NULL DEFAULT '0',
				user_id int NOT NULL,
				booking_currency text NOT NULL,
				token text,
				UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $sql4 );
			
			$sql5 = "ALTER TABLE " . $wpdb->prefix . "ravis_invoice AUTO_INCREMENT=1001";
			dbDelta( $sql5 );
			
			
			/**
			 * Create Newsletter Table
			 * @var string table_name
			 */
			$sql2 = "CREATE TABLE " . ( $wpdb->prefix . 'ravis_newsletter' ) . " (
				id int NOT NULL AUTO_INCREMENT,
				email text NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $sql2 );
			
			
			/**
			 * Create Booking Room table
			 * @var string table_name
			 */
			$sql3 = "CREATE TABLE " . ( $wpdb->prefix . 'ravis_event_booking' ) . " (
				id int NOT NULL AUTO_INCREMENT,
				event_id int NOT NULL,
				guest int NOT NULL,
				guest_name VARCHAR(255) NOT NULL,
				phone VARCHAR(100) NOT NULL,
				email VARCHAR(255) NOT NULL,
				status int NOT NULL DEFAULT '0',
				UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $sql3 );
			
		}
	}
	
	$ravis_database_obj = new Ravis_booking_db_class;