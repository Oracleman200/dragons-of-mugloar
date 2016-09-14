package com.github.javadev.undescriptive.client;

import java.util.Map;
import com.github.underscore.lodash.$;


public class PlayGame {

   
    public static void main(String[] args) {
       
 GameClient client = HttpClient.createDefault();



Map<String, Object> game = client.getGame();



Map<String, Object> weatherResponse = client.getWeather((Long) $.get(game, "gameId"));



final Map<String, Object> request = client.generateGameSolution((Map<String, Object>) $.get(game, "knight"), weatherResponse);



Map<String, Object> response = client.sendSolution((Long) $.get(game, "gameId"), request);


if ("Victory".equals((String) $.get(response, "status"))) {
    System.out.println("NEW GAME:");
    System.out.println(game);
    System.out.println();
    System.out.println("NEW WEATHER REPORT:");
    System.out.println(weatherResponse);
    System.out.println();
    System.out.println("GAME RESPONSE");
    System.out.println("We win a game"+ response);
    System.out.println();
   
} else if ("SRO".equals((String) $.get(weatherResponse, "code"))) {
     System.out.println("Storm Weather");
}


}
    }
    

