package model;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

import org.jivesoftware.smack.Connection;
import org.jivesoftware.smack.Roster;
import org.jivesoftware.smack.XMPPConnection;
import org.jivesoftware.smack.XMPPException;
import org.jivesoftware.smack.packet.Presence;
import org.jivesoftware.smackx.packet.Nick;
import org.jivesoftware.smackx.packet.VCard;

import app.Spustit;

public class XMPPClient {
	
	public static boolean konec = false;

	private static Connection con;
	private static Presence pr;

	public XMPPClient() throws XMPPException, InterruptedException {
		
		// pripojeni na server
		con = new XMPPConnection(Spustit.xmppSERVER);
		con.connect();
		con.login(Spustit.xmppJMENO, Spustit.xmppHESLO);

		// kazdy si muze nas jabber ucet pridat do svych kontaktu a automaticky
		// obdrzi potvrzeni
		Roster.setDefaultSubscriptionMode(Roster.SubscriptionMode.accept_all);

		// dostupnost - dostupny
		pr = new Presence(Presence.Type.available);

		// nastaveni prezdivky a vCard
		Nick nick = new Nick(Spustit.xmppNICK);
		VCard vCard = new VCard();
		vCard.setJabberId(Spustit.xmppJMENO + "@" + Spustit.xmppSERVER);
		vCard.setNickName(Spustit.xmppNICK);
		vCard.save(con);

		// nove vlakno bude aktualizovat status
		Status st = new Status();
		Thread vlakno = new Thread(st);
		vlakno.start();
		System.out.println("XMPP klient byl uspesne spusten.");

	}

	class Status implements Runnable {
		DateFormat df = new SimpleDateFormat("dd.MM.yyyy HH:mm:ss");
		
		@Override
		public void run() {
			if (konec) {
				con.disconnect();
			}
			while (!konec) {
				Date date = new Date();
				String novyStatus = Spustit.MESTO + ": " + Spustit.teplota+"°C "+Spustit.vlhkost+"% ["+df.format(date)+"]";
				System.out.println(novyStatus);
				aktulizujStatus(novyStatus);
				try {
					Thread.sleep(Spustit.xmppStatusUdateInterval * 1000);
				} catch (InterruptedException e) {
					e.printStackTrace();
				}
			}
		}
	}

	public static void aktulizujStatus(String status) {
		pr.setStatus(status);
		con.sendPacket(pr);
	}

}
