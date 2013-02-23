package model;

import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
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
				InputStream in1, in2;

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
						in1 = new URL(urlTMEPString).openStream();
						// Nutne v TMEP vypnout detekci mobilu, jinak nefunguje pridani!!! 
						// V TMEP je sptane detekce user-agentu.
						
						//System.out.println(urlString);
						in2 = new URL(urlString).openStream();
						
						// TODO Prasarna!!! Predelat na Apache HttpClient http://hc.apache.org/httpcomponents-client-ga/index.html
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
