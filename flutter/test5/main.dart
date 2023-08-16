import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

void main() {
  runApp(WeatherApp());
}

class WeatherApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Weather Forecast App',
      theme: ThemeData(primarySwatch: Colors.blue),
      home: WeatherScreen(),
    );
  }
}

class WeatherScreen extends StatefulWidget {
  @override
  _WeatherScreenState createState() => _WeatherScreenState();
}

class _WeatherScreenState extends State<WeatherScreen> {
  final String apiKey = 'YOUR_API_KEY';
  final String apiUrl =
      'https://api.openweathermap.org/data/2.5/weather?q=CITY_NAME&appid=API_KEY';

  Map<String, dynamic>? weatherData;

  Future<void> fetchWeatherData(String city) async {
    final response = await http.get(Uri.parse(apiUrl.replaceFirst('CITY_NAME', city).replaceFirst('API_KEY', apiKey)));

    if (response.statusCode == 200) {
      setState(() {
        weatherData = json.decode(response.body);
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Weather Forecast')),
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: <Widget>[
          if (weatherData == null)
            Text('Enter a city to get weather forecast')
          else
            Column(
              children: [
                Text('Current Weather in ${weatherData!['name']}'),
                Text('Temperature: ${weatherData!['main']['temp']}°C'),
                Text('Weather: ${weatherData!['weather'][0]['description']}'),
              ],
            ),
          SizedBox(height: 20),
          ElevatedButton(
            onPressed: () async {
              final city = await showDialog<String>(
                context: context,
                builder: (context) => SimpleDialog(
                  title: Text('Enter City Name'),
                  children: [
                    TextFormField(
                      onChanged: (value) {
                        if (value.isNotEmpty) {
                          fetchWeatherData(value);
                        }
                      },
                    ),
                    ElevatedButton(
                      onPressed: () => Navigator.pop(context),
                      child: Text('Done'),
                    ),
                  ],
                ),
              );
              if (city != null) {
                fetchWeatherData(city);
              }
            },
            child: Text('Search City'),
          ),
        ],
      ),
    );
  }
}
