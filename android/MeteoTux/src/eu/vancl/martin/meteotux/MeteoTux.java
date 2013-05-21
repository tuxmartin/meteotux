package eu.vancl.martin.meteotux;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;

import android.appwidget.AppWidgetManager;
import android.appwidget.AppWidgetProvider;
import android.content.ComponentName;
import android.content.Context;
import android.widget.RemoteViews;

public class MeteoTux extends AppWidgetProvider {
	String newline = System.getProperty("line.separator");
	DateFormat df = new SimpleDateFormat("dd.MM. HH:mm");

	@Override
	public void onUpdate(Context context, AppWidgetManager appWidgetManager,
			int[] appWidgetIds) {

		Timer timer = new Timer();
		timer.scheduleAtFixedRate(new MyTime(context, appWidgetManager), 1,
				1000);
		
	}

	private class MyTime extends TimerTask {
		RemoteViews remoteViews;
		AppWidgetManager appWidgetManager;
		ComponentName thisWidget;

		public MyTime(Context context, AppWidgetManager appWidgetManager) {
			this.appWidgetManager = appWidgetManager;
			remoteViews = new RemoteViews(context.getPackageName(),
					R.layout.main);
			thisWidget = new ComponentName(context, MeteoTux.class);
		}

		@Override
		public void run() {
			aktualizujTextWidgetu();
		}

		public void aktualizujTextWidgetu() {
			URL url;
			try {
				url = new URL("http://eu.vancl.eu/jicin-teplota/aktualni-teplota-v-jicine.txt");
				url.openConnection();

				BufferedReader in = new BufferedReader(new InputStreamReader(url.openStream()));
				String line;
				StringBuffer buffer = new StringBuffer();
				while ((line = in.readLine()) != null) {
					buffer.append(line);
				}
				in.close();
				
				Date date = new Date();
				String precteno = buffer.toString().replace(" ", "\n");
				remoteViews.setTextViewText(R.id.widget_textview, precteno + "°C\n" + df.format(date));	
				
			} catch (MalformedURLException e) {
				System.out.println("MalformedURLException");
				e.printStackTrace();
			} catch (IOException e) {
				System.out.println("IOException");
				e.printStackTrace();
			}

			appWidgetManager.updateAppWidget(thisWidget, remoteViews);			
		}
		
	}
}
