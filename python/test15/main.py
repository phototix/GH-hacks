import os
import nltk
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score

# Step 1: Data Ingestion
def read_files(directory):
    data = []
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith(".txt"):
                with open(os.path.join(root, file), "r") as text_file:
                    data.append(text_file.read())
    return data

# Step 2: Data Preprocessing
def preprocess_data(data):
    # Tokenization, stopword removal, etc. goes here
    # For simplicity, we'll just use NLTK's word tokenizer
    return [nltk.word_tokenize(text) for text in data]

# Step 3: Feature Extraction
def extract_features(data):
    vectorizer = TfidfVectorizer()
    return vectorizer.fit_transform(data)

# Step 4: Model Training
def train_model(X, y):
    model = RandomForestClassifier()
    model.fit(X, y)
    return model

# Step 5: Evaluation
def evaluate_model(model, X_test, y_test):
    predictions = model.predict(X_test)
    return accuracy_score(y_test, predictions)

# Assume we have a folder structure with text files
data_directory = "path/to/your/text/files"

# Assume we have a way to generate labels for each text file
# This will depend on your specific project
labels = generate_labels()

# Read and preprocess the data
raw_data = read_files(data_directory)
processed_data = preprocess_data(raw_data)

# Extract features
X = extract_features(processed_data)
y = labels

# Split the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2)

# Train the model
model = train_model(X_train, y_train)

# Evaluate the model
print("Model Accuracy: ", evaluate_model(model, X_test, y_test))
