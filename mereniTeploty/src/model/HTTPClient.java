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
				InputStream in;

				try {
					String urlString =  Spustit.httpURL + "?" +
							Spustit.httpHesloParam + "=" + Spustit.httpHeslo + "&" +
							Spustit.httpTeplotaParam + "=" + Spustit.teplota + "&" +
							Spustit.httpVlhkostParam + "=" + Spustit.vlhkost + "&" +
							Spustit.httpDateTimeParam + "=" + df.format(date);
										
					if ( ! (Spustit.teplota.isEmpty() && Spustit.vlhkost.isEmpty()) ) {
						System.out.println(urlString);
						in = new URL(urlString).openStream();
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
