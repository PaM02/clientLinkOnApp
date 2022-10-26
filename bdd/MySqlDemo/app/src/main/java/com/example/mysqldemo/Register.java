package com.example.mysqldemo;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

public class Register extends AppCompatActivity {

    EditText username,prenom,nom,tel,password,numcompteur;
    String srt_username,srt_prenom,srt_nom,srt_tel,srt_password,srt_numcompteur;
    static TextView textView2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        username = findViewById(R.id.username);
        prenom = findViewById(R.id.prenom);
        nom = findViewById(R.id.nom);
        tel = findViewById(R.id.tel);
        password = findViewById(R.id.password);
        numcompteur = findViewById(R.id.numcompteur);

        textView2 = findViewById(R.id.textView2);
    }

    public void OnReg(View view) {
        srt_username = username.getText().toString();
        srt_prenom = prenom.getText().toString();
        srt_nom = nom.getText().toString();
        srt_tel = tel.getText().toString();
        srt_password = password.getText().toString();
        srt_numcompteur = numcompteur.getText().toString();

        String type = "register";
        InsertToDataBase insertToDataBase = new InsertToDataBase(this);
        insertToDataBase.execute(type, srt_username, srt_prenom,srt_nom,srt_tel,srt_password,srt_numcompteur);

    }
}
