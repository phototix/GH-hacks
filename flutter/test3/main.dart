import 'package:flutter/material.dart';

void main() => runApp(EmojiMessengerApp());

class EmojiMessengerApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: EmojiMessenger(),
    );
  }
}

class EmojiMessenger extends StatefulWidget {
  @override
  _EmojiMessengerState createState() => _EmojiMessengerState();
}

class _EmojiMessengerState extends State<EmojiMessenger> {
  String selectedEmoji = ""; // Variable to store the selected emoji

  void _handleEmojiTap(String emoji) {
    setState(() {
      selectedEmoji = emoji;
    });
  }

  void _sendEmoji() {
    // In a real app, you can send the selected emoji to the recipient
    print("Sending emoji: $selectedEmoji");
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Emoji Messenger'),
      ),
      body: Column(
        children: [
          Expanded(
            child: ListView(
              scrollDirection: Axis.horizontal,
              children: [
                _buildEmojiButton("😃"),
                _buildEmojiButton("😍"),
                _buildEmojiButton("🎉"),
                // Add more emojis here...
              ],
            ),
          ),
          ElevatedButton(
            onPressed: _sendEmoji,
            child: Text("Send"),
          ),
        ],
      ),
    );
  }

  Widget _buildEmojiButton(String emoji) {
    return GestureDetector(
      onTap: () => _handleEmojiTap(emoji),
      child: Container(
        padding: EdgeInsets.all(16),
        child: Text(
          emoji,
          style: TextStyle(fontSize: 24),
        ),
      ),
    );
  }
}
