def is_palindrome(word):
    cleaned_word = "".join(filter(str.isalnum, word)).lower()
    return cleaned_word == cleaned_word[::-1]

if __name__ == "__main__":
    input_word = input("Enter a word: ")
    if is_palindrome(input_word):
        print("It's a palindrome!")
    else:
        print("It's not a palindrome!")