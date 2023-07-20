import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: ImageSelectorScreen(),
    );
  }
}

class ImageSelectorScreen extends StatefulWidget {
  @override
  _ImageSelectorScreenState createState() => _ImageSelectorScreenState();
}

class _ImageSelectorScreenState extends State<ImageSelectorScreen> {
  File? _selectedImage;

  void _selectImage() async {
    final pickedImage = await ImagePicker().getImage(source: ImageSource.gallery);
    if (pickedImage != null) {
      setState(() {
        _selectedImage = File(pickedImage.path);
      });
    }
  }

  void _showFullScreenImage() {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => FullScreenImageScreen(imageFile: _selectedImage!),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Image Selector'),
      ),
      body: Center(
        child: _selectedImage == null
            ? ElevatedButton(
                onPressed: _selectImage,
                child: Text('Select Image'),
              )
            : GestureDetector(
                onTap: _showFullScreenImage,
                child: Image.file(
                  _selectedImage!,
                  fit: BoxFit.cover,
                ),
              ),
      ),
    );
  }
}

class FullScreenImageScreen extends StatelessWidget {
  final File imageFile;

  FullScreenImageScreen({required this.imageFile});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Full Screen Image'),
      ),
      body: Center(
        child: Image.file(
          imageFile,
          fit: BoxFit.fill,
        ),
      ),
    );
  }
}
