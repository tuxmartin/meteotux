package app;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

import model.HTTPClient;
import model.RS232;
import model.XMPPClient;

import org.jivesoftware.smack.XMPPException;

public class Spustit {
	private static RS232 port232;
	private static XMPPClient jabber;
	private static HTTPClient http;
	
	public static final String rs232PortName = "/dev/ttyUSB0";
	public static final int rs232BaudRate = 9600;
	public static final int rs232Timeout = 10;	
	public static final int rs232FrekvenceCteni = 1;	
	
	public static final String xmppSERVER = "jabber.cz";
<<<<<<< HEAD
	//public static final String xmppJMENO = "prihlasovaci jmeno";
	//public static final String xmppHESLO = "a heslo...";
	public static final String xmppJMENO = "pokus123";
	public static final String xmppHESLO = "pokus123";
=======
	public static final String xmppJMENO = "prihlasovaci jmeno";
	public static final String xmppHESLO = "a heslo...";
>>>>>>> bf001dfae6a4248a1da6d526634668e36fc57980
	public static final String xmppNICK = "Pokus 123 :-)";
	public static final int xmppStatusUdateInterval = 10;
	public static final String MESTO = "Jičín";
	public static final String httpURL = "http://localhost/martin/teplota/www/teplota.php";
	public static final String httpHeslo = "sbTmdp12wS";
	public static final String httpHesloParam = "h";
	public static final String httpTeplotaParam = "t";
	public static final String httpVlhkostParam = "v";
	public static final String httpDateTimeParam = "d";
	public static final int httpUdateInterval = 10;
	
	
	public static String teplota = "";
	public static String vlhkost = "";
	
	private static boolean ukoncit = false;
	
	public static void main(String[] args) throws InterruptedException, XMPPException {
		port232 = new RS232(rs232PortName, rs232BaudRate);
		jabber = new XMPPClient();
		http = new HTTPClient();

		class SeriovyPort implements Runnable {	
			DateFormat df = new SimpleDateFormat("dd.MM.yyyy HH:mm:ss ");

			@SuppressWarnings("static-access")
			@Override
			public void run() {
				while (!ukoncit) {
					String nacteno = "";
					Date date = new Date();
					try {
						nacteno = port232.cti(rs232Timeout * 1000);
						nacteno = nacteno.trim(); // odstrani konec radku
					} catch (InterruptedException e) {
						e.printStackTrace();
					}
										
					System.out.println(df.format(date) + nacteno);					
					
					nacteno = nacteno.replace("C", "");
					nacteno = nacteno.replace("%", "");					
					String[] namereneHodnoty = nacteno.split(" "); // index 0 = teplota, index 1 = vlhkost
					teplota = namereneHodnoty[0];
					vlhkost = namereneHodnoty[1];
					System.out.println(df.format(date)+"Teplota = "+teplota+"°C Vlhkost = "+vlhkost+"%");
					
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
