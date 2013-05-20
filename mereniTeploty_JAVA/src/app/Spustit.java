package app;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Properties;

import model.HTTPClient;
import model.RS232;
import model.XMPPClient;

import org.jivesoftware.smack.XMPPException;

public class Spustit {
	private static RS232 port232;
//	private static XMPPClient jabber;
	private static HTTPClient http;
	
	public static final String rs232PortName;
	public static final int rs232BaudRate;
	public static final int rs232Timeout;
	public static final int rs232FrekvenceCteni;	
	
	public static final String xmppSERVER;
	public static final String xmppJMENO;
	public static final String xmppHESLO;
	public static final String xmppNICK;
	public static final int xmppStatusUdateInterval;
	public static final String MESTO;
	public static final String httpURL;
	public static final String httpHeslo;
	public static final String httpHesloParam;
	public static final String httpTeplotaParam;
	public static final String httpVlhkostParam;
	public static final String httpDateTimeParam;
	public static final int httpUdateInterval;
	public static final String httpTMEP;
	
	public static String teplota = "";
	public static String vlhkost = "";
	
	private static boolean ukoncit = false;
	
	static {
		Properties p = new Properties();
		try {
			p.load(new FileInputStream("nastaveni.ini"));						
		} catch (FileNotFoundException e) {
			System.out.println("Soubor s nastavenim nenalezen!");
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}			
		
		rs232PortName = p.getProperty("rs232PortName");
		rs232BaudRate = Integer.parseInt(p.getProperty("rs232BaudRate"));
		rs232Timeout = Integer.parseInt(p.getProperty("rs232Timeout"));
		rs232FrekvenceCteni = Integer.parseInt(p.getProperty("rs232FrekvenceCteni"));							
		xmppSERVER = p.getProperty("xmppSERVER");
		xmppJMENO = p.getProperty("xmppJMENO");
		xmppHESLO = p.getProperty("xmppHESLO");
		xmppNICK = p.getProperty("xmppNICK");
		xmppStatusUdateInterval = Integer.parseInt(p.getProperty("xmppStatusUdateInterval"));
		MESTO = p.getProperty("MESTO");
		httpURL = p.getProperty("httpURL");
		httpHeslo = p.getProperty("httpHeslo");
		httpHesloParam = p.getProperty("httpHesloParam");
		httpTeplotaParam = p.getProperty("httpTeplotaParam");
		httpVlhkostParam = p.getProperty("httpVlhkostParam");
		httpDateTimeParam = p.getProperty("httpDateTimeParam");
		httpUdateInterval = Integer.parseInt(p.getProperty("httpUdateInterval"));
		httpTMEP = p.getProperty("httpTMEP");
	}
	
	public static void main(String[] args) throws InterruptedException, XMPPException {
		port232 = new RS232(rs232PortName, rs232BaudRate);
//		jabber = new XMPPClient();
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
