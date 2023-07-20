import re
from collections import Counter

def extract_4_digit_numbers(text):
    return re.findall(r'\b\d{4}\b', text)

def main():
    filename = 'data.txt'  # Replace with the actual filename
    with open(filename, 'r') as file:
        file_content = file.read()

    # Split the file content into sections based on "========="
    sections = file_content.split('=========\n')

    all_numbers = []
    for section in sections:
        numbers = extract_4_digit_numbers(section)
        all_numbers.extend(numbers)

    number_counts = Counter(all_numbers)

    # Get the three most frequent 4-digit numbers
    most_frequent = number_counts.most_common(3)

    # Get the three least frequent 4-digit numbers
    least_frequent = number_counts.most_common()[:-4:-1]

    print("Three most frequent 4-digit numbers:")
    for number, count in most_frequent:
        print(f"{number}: {count} occurrences")

    print("\nThree least frequent 4-digit numbers:")
    for number, count in least_frequent:
        print(f"{number}: {count} occurrences")

if __name__ == "__main__":
    main()
