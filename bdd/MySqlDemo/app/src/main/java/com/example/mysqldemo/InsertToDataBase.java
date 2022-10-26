package com.example.mysqldemo;

import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.widget.Toast;

import androidx.annotation.RequiresApi;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.nio.charset.StandardCharsets;

public class InsertToDataBase extends AsyncTask<String,Void,String> {
    @SuppressLint("StaticFieldLeak")
    private Context context;
    private String msg;
    private ProgressDialog progress;

    InsertToDataBase (Context context) {
        this.context = context;
    }

    @Override
    protected void onPreExecute() {

        progress = ProgressDialog.show(context, "Connexion en cours","Merci de patienter..", true);

    }

    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    @Override
    protected String doInBackground(String... strings) {

        String type = strings[0];
        String register_url = "http://192.168.43.6/clientLinkOnApp/register.php";
        if (type.equals("register")){

            try {

                String username = strings[1];
                String prenom = strings[2];
                String nom = strings[3];
                String tel = strings[4];
                String password = strings[5];
                String numcompteur = strings[6];

                URL url = new URL(register_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, StandardCharsets.UTF_8));


                String post_data = URLEncoder.encode("username","UTF-8")+"="+URLEncoder.encode(username,"UTF-8")+"&"
                        +URLEncoder.encode("prenom","UTF-8")+"="+URLEncoder.encode(prenom,"UTF-8")+"&"
                        +URLEncoder.encode("nom","UTF-8")+"="+URLEncoder.encode(nom,"UTF-8")+"&"
                        +URLEncoder.encode("tel","UTF-8")+"="+URLEncoder.encode(tel,"UTF-8")+"&"
                        +URLEncoder.encode("password","UTF-8")+"="+URLEncoder.encode(password,"UTF-8")+"&"
                        +URLEncoder.encode("numcompteur","UTF-8")+"="+URLEncoder.encode(numcompteur,"UTF-8");

                bufferedWriter.write(post_data);
                bufferedWriter.flush();
                bufferedWriter.close();
                outputStream.close();

                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));

                String line="";
                String result = "";
                while((line = bufferedReader.readLine())!= null) {
                    result += line;

                }

                return result;
            } catch (MalformedURLException e) {

                msg="Merci de verifier votre connexion";
                e.printStackTrace();
            } catch (IOException e) {
                msg="Merci de verifier votre connexion";
                e.printStackTrace();
            }

        }

        return msg;

    }

    @Override
    protected void onPostExecute(String result) {

        progress.dismiss();

        //if (result.equals("11")){

            context.startActivity(new Intent(context,Main2Activity.class));

       /* }
        else {
            Register.textView2.setText(result);
            Toast.makeText(context,result,Toast.LENGTH_SHORT).show();
        }*/

    }
}
