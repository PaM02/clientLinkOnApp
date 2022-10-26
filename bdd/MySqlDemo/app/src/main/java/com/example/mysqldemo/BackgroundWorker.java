package com.example.mysqldemo;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
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



public class BackgroundWorker extends AsyncTask<String,Void,String> {
    @SuppressLint("StaticFieldLeak")
    private Context context;

    private String msg;
    private ProgressDialog progress;

    BackgroundWorker (Context context) {
        this.context = context;
    }

    @Override
    protected void onPreExecute() {

        progress = ProgressDialog.show(context, "Connexion en cours","Merci de patienter..", true);

    }

    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    @Override
    protected String doInBackground(String... params) {

        String type = params[0];
        String login_url = "http://192.168.1.38/login.php";

        if(type.equals("login")) {
            try {
                String user_name = params[1];
                String password = params[2];

                URL url = new URL(login_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection)url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);

                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, StandardCharsets.UTF_8));
                String post_data = URLEncoder.encode("user_name","UTF-8")+"="+URLEncoder.encode(user_name,"UTF-8")+"&"
                        +URLEncoder.encode("password","UTF-8")+"="+URLEncoder.encode(password,"UTF-8");

                bufferedWriter.write(post_data);

                bufferedWriter.flush();
                bufferedWriter.close();
                outputStream.close();

                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));

                String result = "";
                String line="";
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

            if (result.equals("11")){

                context.startActivity(new Intent(context,Main2Activity.class));

            }
            else  if (result.equals("10")){

                MainActivity.textView.setText(result);
                Toast.makeText(context,"les donnees sont incorrect",Toast.LENGTH_SHORT).show();

            }
           else {

               Toast.makeText(context,result,Toast.LENGTH_SHORT).show();
            }

    }


}
