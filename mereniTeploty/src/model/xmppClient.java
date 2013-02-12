package model;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.GregorianCalendar;

import org.jivesoftware.smack.Connection;
import org.jivesoftware.smack.Roster;
import org.jivesoftware.smack.XMPPConnection;
import org.jivesoftware.smack.XMPPException;
import org.jivesoftware.smack.packet.Presence;
import org.jivesoftware.smackx.packet.Nick;
import org.jivesoftware.smackx.packet.VCard;

public class xmppClient {
	private final static String SERVER = "jabber.cz";
	private final static String JMENO = "prihlasovaci jmeno";
	private final static String HESLO = "a heslo...";
	private final static String NICK = "Pokus 123 :-)";
	private final static int STATUS_UPDATE_INTERVAL = 5; // [s]
	
	public static boolean aktualizovat = true;

	private static Connection con;
	private static Presence pr;

	public static void main(String[] args) throws XMPPException,
			InterruptedException {

		// pripojeni na server
		con = new XMPPConnection(SERVER);
		con.connect();
		con.login(JMENO, HESLO);

		// kazdy si muze nas jabber ucet pridat do svych kontaktu, automaticky
		// obdrzi potvrzeni
		Roster.setDefaultSubscriptionMode(Roster.SubscriptionMode.accept_all);

		// dostupnost - dostupny
		pr = new Presence(Presence.Type.available);

		// nastaveni prezdivky a vCard
		Nick nick = new Nick(NICK);
		VCard vCard = new VCard();
		vCard.setJabberId(JMENO + "@" + SERVER);
		vCard.setNickName(NICK);
		vCard.save(con);

		class Status implements Runnable {
			@Override
			public void run() {
				while (aktualizovat) {
					Calendar cal = new GregorianCalendar();
					SimpleDateFormat sdf = new SimpleDateFormat(
							"HH:mm:ss dd.MM.yyyy");
					aktulizujStatus("Právě je: " + sdf.format(cal.getTime()));
					try {
						Thread.sleep(STATUS_UPDATE_INTERVAL * 1000);
					} catch (InterruptedException e) {
						e.printStackTrace();
					}
				}

			}
		}

		// nove vlakno bude aktualizovat status
		Status st = new Status();
		Thread vlakno = new Thread(st);
		vlakno.start();
		System.out.println("XMPP klient byl uspesne spusten.");
		vlakno.join(); // ceka na ukonceni vlakna
						// (ktere v tomto pripade nikdy nenastane)

		con.disconnect();

	}

	public static void aktulizujStatus(String status) {
		pr.setStatus(status);
		con.sendPacket(pr);
	}

}
