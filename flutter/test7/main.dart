import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

void main() => runApp(MyApp());

class MyApp extends StatefulWidget {
  @override
  _MyAppState createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  List<String> tableNames = [];

  @override
  void initState() {
    super.initState();
    fetchData();
  }

  Future<void> fetchData() async {
    final response = await http.get('https://database.brandon.my/tables.php');
    
    if (response.statusCode == 200) {
      final jsonData = json.decode(response.body);
      setState(() {
        tableNames = List<String>.from(jsonData.map((table) => table['Tables_in_your_database']));
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        appBar: AppBar(
          title: Text('Table List'),
        ),
        body: ListView.builder(
          itemCount: tableNames.length,
          itemBuilder: (context, index) {
            return ListTile(
              title: Text(tableNames[index]),
            );
          },
        ),
      ),
    );
  }
}
