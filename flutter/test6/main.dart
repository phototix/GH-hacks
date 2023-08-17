import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

void main() {
  runApp(MovieCatalogApp());
}

class MovieCatalogApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Movie Catalog App',
      theme: ThemeData(primarySwatch: Colors.blue),
      home: MovieCatalogScreen(),
    );
  }
}

class MovieCatalogScreen extends StatefulWidget {
  @override
  _MovieCatalogScreenState createState() => _MovieCatalogScreenState();
}

class _MovieCatalogScreenState extends State<MovieCatalogScreen> {
  final String apiKey = 'YOUR_API_KEY';
  final String apiUrl =
      'https://api.themoviedb.org/3/discover/movie?api_key=API_KEY';

  List<dynamic> movies = [];

  Future<void> fetchMovies() async {
    final response = await http.get(Uri.parse(apiUrl.replaceFirst('API_KEY', apiKey)));

    if (response.statusCode == 200) {
      setState(() {
        movies = json.decode(response.body)['results'];
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Movie Catalog')),
      body: Column(
        children: [
          TextField(
            onChanged: (query) {
              // Implement search functionality
            },
            decoration: InputDecoration(
              hintText: 'Search by title',
              prefixIcon: Icon(Icons.search),
            ),
          ),
          Expanded(
            child: GridView.builder(
              gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                crossAxisSpacing: 10,
                mainAxisSpacing: 10,
              ),
              itemCount: movies.length,
              itemBuilder: (context, index) {
                final movie = movies[index];
                return GestureDetector(
                  onTap: () {
                    // Navigate to movie detail screen
                  },
                  child: Image.network(
                    'https://image.tmdb.org/t/p/w500/${movie['poster_path']}',
                    fit: BoxFit.cover,
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}
