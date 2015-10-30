package com.example.markus.locationbasedadventure;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.widget.Button;
import android.widget.ImageView;

import com.example.markus.locationbasedadventure.AsynchronTasks.SyndicateStatsLocalToServerTask;
import com.example.markus.locationbasedadventure.Database.ArmorDatabase;
import com.example.markus.locationbasedadventure.Database.CharacterdataDatabase;
import com.example.markus.locationbasedadventure.Database.ItemDatabase;
import com.example.markus.locationbasedadventure.Database.StatsDatabase;
import com.example.markus.locationbasedadventure.Database.WeaponDatabase;

public class SplashActivity extends Activity {


    private Button anmeldenPage;
    private Button registrierenPage;
    private CharacterdataDatabase characterdataDb;
    private StatsDatabase statsDb;
    private WeaponDatabase weaponDb;
    private ArmorDatabase armorDb;
    private ItemDatabase itemDb;

    private String address2 = "http://sruball.de/Ratismon/syndicateData.php";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);
        initDB();
        setSplashImage();
        checkAnmeldung();
    }

    //closes Database if Activity is destroyed

    @Override
    protected void onDestroy() {
        characterdataDb.close();
        statsDb.close();
        armorDb.close();
        weaponDb.close();
        itemDb.close();
        super.onDestroy();
    }

    private void setSplashImage() {
        ImageView splash = (ImageView) findViewById(R.id.splash);
        splash.setImageResource(R.drawable.splash);
    }

    private void waitALittleMain(int time) {
        Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            public void run() {
                Intent intent = new Intent(SplashActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        }, time);
    }
    private void waitALittleMaps(int time) {
        Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            public void run() {
                Intent intent = new Intent(SplashActivity.this,MapsActivity.class);
                startActivity(intent);
                finish();
            }
        }, time);
    }

    private void checkAnmeldung() {
        if (characterdataDb.isEmpty()) {
            characterdataDb.insertAllmainActivity();
        }
        if (statsDb.isEmpty()) {
            statsDb.insertAllmainActivity();
        }
        if (weaponDb.isEmpty()) {
            weaponDb.insertAllmainActivity();
        }
        if (armorDb.isEmpty()) {
            armorDb.insertAllmainActivity();
        }


        if (characterdataDb.getStayAngemeldet() == 1) {
            new SyndicateStatsLocalToServerTask(this).execute(address2, characterdataDb.getEmail(), "" + statsDb.getLevel(), "" + statsDb.getExp(), "" + statsDb.getStamina(), "" + statsDb.getStrength(), "" + statsDb.getDexterity(), "" + statsDb.getIntelligence());
            waitALittleMaps(2000);
        }else{
            waitALittleMain(2000);
        }
    }

    //initialises Databases
    // Open Databases

    private void initDB() {
        characterdataDb = new CharacterdataDatabase(this);
        characterdataDb.open();
        statsDb = new StatsDatabase(this);
        statsDb.open();
        weaponDb = new WeaponDatabase(this);
        weaponDb.open();
        armorDb = new ArmorDatabase(this);
        armorDb.open();
        itemDb = new ItemDatabase(this);
        itemDb.open();


    }
}
