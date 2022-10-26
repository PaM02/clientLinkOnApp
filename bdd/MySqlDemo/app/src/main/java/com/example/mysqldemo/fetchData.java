package com.example.mysqldemo;

import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;

public class fetchData extends  AsyncTask<String,Void,String>{
    private String data ="";
    private String username,password,prenom,nom,numC,tel;
    @SuppressLint("StaticFieldLeak")
    private Context context;
    private Boolean aBoolean=false;
    private ProgressDialog progress;

    fetchData (Context context) {
        this.context = context;
    }

    @Override
    protected void onPreExecute() {

        progress = ProgressDialog.show(context, "Connexion en cours","Merci de patienter..", true);

    }

    @Override
    protected String doInBackground(String... strings) {
        try {
             username=strings[0];
             password=strings[1];

            URL url = new URL("http://192.168.43.6/clientLinkOnApp/login2.php");
            HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
            InputStream inputStream = httpURLConnection.getInputStream();
            BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
            String line = "";
            while(line != null){
                line = bufferedReader.readLine();
                data = data + line;
            }

            JSONArray JA = new JSONArray(data);
            for(int i =0 ;i < JA.length(); i++){

                JSONObject jsonObject = (JSONObject) JA.get(i);
                String nameuser = jsonObject.getString("username");
                String pass = jsonObject.getString("password");
                if (nameuser.equals(username) && pass.equals(password)){

                      prenom =jsonObject.getString("prenom");
                      nom=jsonObject.getString("nom");
                      tel=jsonObject.getString("tel");
                      numC =jsonObject.getString("numcompteur");
                      aBoolean=true;

                }

            }

        } catch (MalformedURLException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } catch (JSONException e) {
            e.printStackTrace();
        }

        return null;
    }

    @Override
    protected void onPostExecute(String s) {

        progress.dismiss();
        if (aBoolean){
            MainActivity.textView.setText("c'est ok "+username+"  "+prenom+" nom: "+nom+" tel: "+tel+" pass: "+password+" compteur: "+numC);

        }
        else {

            Toast.makeText(context,"les donees sont incorrect",Toast.LENGTH_SHORT).show();

        }

    }
}
