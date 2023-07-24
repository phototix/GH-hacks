import random

def get_random_joke():
    jokes = [
        "Why don't scientists trust atoms? Because they make up everything!",
        "What's orange and sounds like a parrot? A carrot!",
        "Why don't skeletons fight each other? They don't have the guts!",
        "Why couldn't the bicycle stand up by itself? It was two-tired!",
        "Why was the math book sad? Because it had too many problems!"
    ]

    return random.choice(jokes)

if __name__ == "__main__":
    joke = get_random_joke()
    print("Here's a random joke for you:")
    print(joke)
