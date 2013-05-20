package model;
import java.io.IOException;
import java.io.OutputStream;

public class SerialWriter extends Thread {
	OutputStream out;
	private char znak;
	private int uspat = 0;

	public SerialWriter(OutputStream out, char znak, int cekat) {
		this.out = out;
		this.znak = znak;
		this.uspat = cekat;
	}

	public SerialWriter(OutputStream out, char znak) {
		this.out = out;
		this.znak = znak;
	}

	public void run() {
		try {

			Thread.sleep(uspat);
			this.out.write(znak);

			this.out.flush();

		} catch (IOException e) {
			e.printStackTrace();
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}
}