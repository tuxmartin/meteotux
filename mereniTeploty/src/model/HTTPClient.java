package model;

import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

import app.Spustit;

public class HTTPClient {
	public static boolean konec = false;

	public HTTPClient() {
		// nove vlakno bude odesilat data
		Odeslat od = new Odeslat();
		Thread vlakno = new Thread(od);
		vlakno.start();
		System.out.println("HTTP klient byl uspesne spusten.");
	}

	class Odeslat implements Runnable {
		DateFormat df = new SimpleDateFormat("yyyy-MM-dd%20HH:mm:ss"); // MySQL format data a casu

		@Override
		public void run() {
			while (!konec) {
				Date date = new Date();

				try {
					String urlString =  Spustit.httpURL + "?" +
							Spustit.httpHesloParam + "=" + Spustit.httpHeslo + "&" +
							Spustit.httpTeplotaParam + "=" + Spustit.teplota + "&" +
							Spustit.httpVlhkostParam + "=" + Spustit.vlhkost + "&" +
							Spustit.httpDateTimeParam + "=" + df.format(date);
					
					// http://localhost/martin/TMEP-6.1/app/index.php?tempV=+21.50&humV=50.45
					// http://code.google.com/p/tmep/
					String urlTMEPString =  Spustit.httpTMEP + "?" +
							"tempV=" + Spustit.teplota + "&" +
							"humV=" + Spustit.vlhkost ;
					
										
					if ( ! (Spustit.teplota.isEmpty() && Spustit.vlhkost.isEmpty()) ) {
						
						//System.out.println(urlTMEPString);
						URLConnection con = new URL(urlTMEPString).openConnection();
				        con.setRequestProperty("User-Agent", "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.70 Safari/537.17");
				        InputStream response = con.getInputStream();
						
						//System.out.println(urlString);
				        InputStream in = new URL(urlString).openStream();
						
						// TODO Zvazit prpesani pomociApache HttpClient http://hc.apache.org/httpcomponents-client-ga/index.html
					}
					
				 
				} catch (MalformedURLException e1) {
					e1.printStackTrace();
				} catch (IOException e1) {
					e1.printStackTrace();
				}

				try {
					Thread.sleep(Spustit.httpUdateInterval * 1000);
				} catch (InterruptedException e) {
					e.printStackTrace();
				}
			}
		}
	}

}
