package app;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import model.RS232;

public class Spustit {
	private static RS232 port232;
	
	private static final String rs232PortName = "/dev/ttyUSB0";
	private static final int rs232BaudRate = 9600;
	private static final int rs232Timeout = 10;	
	private static final int rs232FrekvenceCteni = 1;	
	
	private static boolean ukoncit = false;
	
	public static void main(String[] args) throws InterruptedException {
		port232 = new RS232(rs232PortName, rs232BaudRate);

		class SeriovyPort implements Runnable {	
			DateFormat df = new SimpleDateFormat("dd.MM.yyyy HH:mm:ss");

			@SuppressWarnings("static-access")
			@Override
			public void run() {
				while (!ukoncit) {
					String abc = "";
					try {
						abc = port232.cti(rs232Timeout * 1000);
					} catch (InterruptedException e) {
						e.printStackTrace();
					}
					
					Date date = new Date();
					System.out.println(df.format(date) + " " + abc);
					
					try {
						Thread.sleep(rs232FrekvenceCteni*1000);
					} catch (InterruptedException e) {
						e.printStackTrace();
					}

				}
				

			}
			
		}
		
		SeriovyPort sp = new SeriovyPort();
		Thread vlaknoSP = new Thread(sp);
		vlaknoSP.start();
		vlaknoSP.join(); // ceka na ukonceni vlakna

		
	}

}
